<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranAsetTim;
use App\Models\PembayaranIplRuko;
use App\Models\WifiPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PaymentApprovalApiController extends Controller
{
    private const APPROVER_ROLES = ['admin', 'head_of_store', 'hr', 'gm', 'ceo'];

    private function getModelClass(string $jenis): string
    {
        return match ($jenis) {
            'internet' => WifiPayment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
            'aset_tim' => PembayaranAsetTim::class,
            default => abort(400, 'Jenis tidak valid'),
        };
    }

    public function index()
    {
        $all = collect();

        foreach ([
            'internet' => WifiPayment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
            'aset_tim' => PembayaranAsetTim::class,
        ] as $jenis => $class) {
            $records = $class::with('requester', 'approver')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($r) => [
                    'id' => $r->id,
                    'jenis' => $jenis,
                    'jenis_label' => $this->jenisLabel($jenis),
                    'detail' => $jenis === 'internet' ? $r->nama_internet : $r->periode,
                    'provider' => $r->provider ?? '-',
                    'nominal' => (int) ($r->biaya ?? $r->nominal),
                    'status' => $r->status,
                    'tanggal_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                    'bukti_url' => $r->bukti_bayar ? route('files.show', $r->bukti_bayar) : null,
                    'requester_name' => $r->requester?->name ?? '-',
                    'pic' => $r->pic,
                    'jabatan' => $r->jabatan,
                    'created_at' => $r->created_at->format('Y-m-d H:i:s'),
                ]);
            $all = $all->merge($records);
        }

        $requests = $all->sortByDesc('created_at')->values();

        return response()->json([
            'total' => $requests->count(),
            'data' => $requests,
        ]);
    }

    public function approve($id, Request $request)
    {
        $jenis = $request->input('jenis');

        if (! in_array(auth()->user()->role, self::APPROVER_ROLES)) {
            return response()->json(['error' => 'Anda tidak memiliki hak akses untuk approve.'], 403);
        }

        $class = $this->getModelClass($jenis);
        $record = $class::findOrFail($id);

        if ($record->status !== 'pending') {
            return response()->json(['error' => 'Request sudah diproses.'], 422);
        }

        if ($record->requested_by === auth()->id()) {
            return response()->json(['error' => 'Anda tidak bisa menyetujui pengajuan Anda sendiri.'], 403);
        }

        $period = $record->period ?? 'bulanan';
        $offsetMonths = $period === 'tahunan' ? 12 : 1;

        $record->update([
            'status' => 'lunas',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $fillable = $record->getFillable();
        $newData = [];
        foreach ($fillable as $col) {
            if (in_array($col, ['id', 'status', 'tanggal_bayar', 'requested_by', 'approved_by', 'approved_at', 'bukti_bayar', 'notes', 'created_at', 'updated_at', 'period'])) {
                continue;
            }
            $newData[$col] = $record->$col;
        }
        $newData['period'] = 'bulanan';

        $dateField = $jenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
        $newData[$dateField] = $record->{$dateField}->copy()->addMonths($offsetMonths);
        $newData['status'] = $newData[$dateField]->lte(now()->addDays(7)) ? 'jatuh_tempo' : 'pending';
        if ($jenis !== 'internet') {
            $newData['tanggal_tagihan'] = $record->tanggal_tagihan?->copy()->addMonths($offsetMonths) ?? now();
        }

        $class::create($newData);

        if ($record->requested_by) {
            $detail = $jenis === 'internet' ? $record->nama_internet : $record->periode;
            $message = "Pembayaran {$this->jenisLabel($jenis)} ({$detail}) telah disetujui oleh ".auth()->user()->name.'.';
            Notification::send($record->requested_by, 'activity', 'Pembayaran Disetujui', $message, route('payment-approval.status'));
            Cache::forget('tagihan_check_'.$record->requested_by);
        }

        Cache::forget('approval_check_'.auth()->id());

        return response()->json(['success' => true, 'message' => 'Payment approved successfully']);
    }

    public function reject($id, Request $request)
    {
        $jenis = $request->input('jenis');

        if (! in_array(auth()->user()->role, self::APPROVER_ROLES)) {
            return response()->json(['error' => 'Anda tidak memiliki hak akses untuk reject.'], 403);
        }

        $data = $request->validate(['notes' => 'required|string|max:1000']);

        $class = $this->getModelClass($jenis);
        $record = $class::findOrFail($id);

        if ($record->status !== 'pending') {
            return response()->json(['error' => 'Request sudah diproses.'], 422);
        }

        if ($record->requested_by === auth()->id()) {
            return response()->json(['error' => 'Anda tidak bisa menolak pengajuan Anda sendiri.'], 403);
        }

        $record->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $data['notes'],
        ]);

        if ($record->requested_by) {
            $detail = $jenis === 'internet' ? $record->nama_internet : $record->periode;
            $message = "Pembayaran {$this->jenisLabel($jenis)} ({$detail}) ditolak. Alasan: {$data['notes']}";
            Notification::send($record->requested_by, 'activity', 'Pembayaran Ditolak', $message, route('payment-approval.status'));
            Cache::forget('tagihan_check_'.$record->requested_by);
        }

        Cache::forget('approval_check_'.auth()->id());

        return response()->json(['success' => true, 'message' => 'Payment rejected successfully']);
    }

    private function jenisLabel(string $jenis): string
    {
        return match ($jenis) {
            'internet' => 'Internet',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
            'aset_tim' => 'Aset TIM',
            default => ucfirst($jenis),
        };
    }
}
