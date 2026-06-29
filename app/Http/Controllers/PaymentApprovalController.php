<?php

namespace App\Http\Controllers;

use App\Models\DigitalAsset;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\PeralatanKantor;
use App\Models\SimCard;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\WifiPayment;
use App\Exports\DataExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PaymentApprovalController extends Controller
{
    private function getModel(string $jenis)
    {
        return match ($jenis) {
            'internet' => new WifiPayment,
            'listrik' => new Payment,
            'aset_digital' => new PembayaranAsetDigital,
            'ipl_ruko' => new PembayaranIplRuko,
            default => abort(400, 'Jenis tidak valid'),
        };
    }

    private function getModelClass(string $jenis): string
    {
        return match ($jenis) {
            'internet' => WifiPayment::class,
            'listrik' => Payment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
            default => abort(400, 'Jenis tidak valid'),
        };
    }

    public function create()
    {
        return view('payment-approval.create');
    }

    public function store(Request $request)
    {
        $jenis = $request->input('jenis');

        $rules = match ($jenis) {
            'internet' => [
                'nama_internet' => 'required|string|max:255',
                'provider' => 'required|string|max:255',
                'pic' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'masa_tenggang' => 'required|date',
                'biaya' => 'required|numeric|min:0',
            ],
            'listrik', 'aset_digital', 'ipl_ruko' => [
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
            ],
            default => abort(400, 'Jenis tidak valid'),
        };
        $rules['bukti_bayar'] = 'required|image|mimes:jpeg,png,jpg|max:200';
        $rules['tanggal_bayar'] = 'required|date';

        $data = $request->validate($rules);
        $data['status'] = 'pending';
        $data['requested_by'] = auth()->id();
        $data['tanggal_bayar'] = $request->input('tanggal_bayar');

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('payment-bukti', 'public');
            $this->compressBukti($data['bukti_bayar']);
        }

        $model = $this->getModel($jenis);
        $model->fill($data);

        if ($jenis === 'listrik') {
            $model->jenis = 'listrik';
        }

        $model->save();

        // Notifikasi ke GM dan CEO
        $approvers = User::whereIn('role', ['gm', 'ceo'])->get();
        $detail = $jenis === 'internet' ? $data['nama_internet'] : ($data['periode'] ?? '');
        $message = "Pengajuan pembayaran {$jenis}: {$detail} menunggu approval.";

        foreach ($approvers as $approver) {
            Notification::send($approver->id, 'activity', 'Pengajuan Pembayaran', $message, route('admin.payment-approvals.index'));
        }

        Cache::forget('tagihan_check_'.auth()->id());
        Cache::forget('approval_check_'.auth()->id());

        return redirect()->route('payment-approval.status')
            ->with('success', 'Pengajuan pembayaran berhasil dikirim dan menunggu approval.');
    }

    public function myRequests()
    {
        $userId = auth()->id();
        $all = collect();

        foreach ([
            'internet' => WifiPayment::class,
            'listrik' => Payment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
        ] as $jenis => $class) {
            $records = $class::with('requester', 'approver')
                ->where('requested_by', $userId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($r) => [
                    'id' => $r->id,
                    'jenis' => $jenis,
                    'jenis_label' => match ($jenis) {
                        'internet' => 'Internet',
                        'listrik' => 'Listrik',
                        'aset_digital' => 'Aset Digital',
                        'ipl_ruko' => 'IPL Ruko',
                    },
                    'detail' => $jenis === 'internet' ? $r->nama_internet : $r->periode,
                    'nominal' => (int) ($r->biaya ?? $r->nominal),
                    'status' => $r->status,
                    'pic' => $r->pic,
                    'jabatan' => $r->jabatan,
                    'tanggal_bayar' => $r->tanggal_bayar?->format('d/m/Y'),
                    'bukti_url' => $r->bukti_bayar ? url('storage/'.$r->bukti_bayar) : null,
                    'approver_name' => $r->approver?->name,
                    'approved_at' => $r->approved_at?->format('d/m/Y H:i'),
                    'notes' => $r->notes,
                    'created_at' => $r->created_at->format('d/m/Y H:i'),
                ]);
            $all = $all->merge($records);
        }

        $requests = $all->sortByDesc('created_at')->values();

        return view('payment-approval.status', compact('requests'));
    }

    public function tagihan()
    {
        $all = collect();

        foreach ([
            'internet' => WifiPayment::class,
            'listrik' => Payment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
        ] as $jenis => $class) {
            $records = $class::with('requester')
                ->where('status', 'jatuh_tempo')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($r) => [
                    'id' => $r->id,
                    'jenis' => $jenis,
                    'jenis_label' => match ($jenis) {
                        'internet' => 'Internet',
                        'listrik' => 'Listrik',
                        'aset_digital' => 'Aset Digital',
                        'ipl_ruko' => 'IPL Ruko',
                    },
                    'detail' => $jenis === 'internet' ? $r->nama_internet : $r->periode,
                    'nominal' => (int) ($r->biaya ?? $r->nominal),
                    'status' => $r->status,
                    'tanggal_bayar' => $r->tanggal_bayar?->format('d/m/Y'),
                ]);
            $all = $all->merge($records);
        }

        $tagihan = $all->sortByDesc('created_at')->values();

        $jabatanList = Vehicle::distinct()->pluck('jabatan')
            ->merge(DigitalAsset::distinct()->pluck('jabatan'))
            ->merge(SimCard::distinct()->pluck('jabatan'))
            ->merge(PeralatanKantor::distinct()->pluck('jabatan'))
            ->merge(WifiPayment::distinct()->pluck('jabatan'))
            ->unique()
            ->filter()
            ->sort()
            ->values();

        return view('payment-approval.tagihan', compact('tagihan', 'jabatanList'));
    }

    public function bayar($id, Request $request)
    {
        $jenis = $request->input('jenis');

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:200',
            'tanggal_bayar' => 'required|date',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $class = $this->getModelClass($jenis);
        $record = $class::findOrFail($id);

        if ($record->status !== 'jatuh_tempo') {
            return redirect()->route('payment-approval.tagihan')
                ->with('error', 'Tagihan sudah diproses.');
        }

        $buktiPath = $request->file('bukti_bayar')->store('payment-bukti', 'public');
        $this->compressBukti($buktiPath);

        $record->update([
            'status' => 'pending',
            'requested_by' => auth()->id(),
            'pic' => $request->input('pic'),
            'jabatan' => $request->input('jabatan'),
            'tanggal_bayar' => $request->input('tanggal_bayar'),
            'bukti_bayar' => $buktiPath,
        ]);

        $detail = $jenis === 'internet' ? $record->nama_internet : $record->periode;
        $jenisLabel = match ($jenis) {
            'internet' => 'Internet',
            'listrik' => 'Listrik',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
        };
        $message = "Pembayaran {$jenisLabel} ({$detail}) menunggu approval.";

        $approvers = User::whereIn('role', ['gm', 'ceo'])->get();
        foreach ($approvers as $approver) {
            Notification::send($approver->id, 'activity', 'Pengajuan Pembayaran', $message, route('admin.payment-approvals.index'));
            Cache::forget('approval_check_'.$approver->id);
        }

        Cache::forget('tagihan_check_'.auth()->id());

        return redirect()->route('payment-approval.status')
            ->with('success', 'Bukti bayar berhasil dikirim. Menunggu persetujuan GM/CEO.');
    }

    public function index()
    {
        $all = collect();

        foreach ([
            'internet' => WifiPayment::class,
            'listrik' => Payment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
        ] as $jenis => $class) {
            $records = $class::with('requester', 'approver')
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($r) => [
                    'id' => $r->id,
                    'jenis' => $jenis,
                    'jenis_label' => match ($jenis) {
                        'internet' => 'Internet',
                        'listrik' => 'Listrik',
                        'aset_digital' => 'Aset Digital',
                        'ipl_ruko' => 'IPL Ruko',
                    },
                    'detail' => $jenis === 'internet' ? $r->nama_internet : $r->periode,
                    'provider' => $r->provider ?? '-',
                    'nominal' => (int) ($r->biaya ?? $r->nominal),
                    'status' => $r->status,
                    'tanggal_bayar' => $r->tanggal_bayar?->format('d/m/Y'),
                    'bukti_url' => $r->bukti_bayar ? url('storage/'.$r->bukti_bayar) : null,
                    'requester_name' => $r->requester?->name ?? '-',
                    'pic' => $r->pic,
                    'jabatan' => $r->jabatan,
                    'created_at' => $r->created_at->format('d/m/Y H:i'),
                ]);
            $all = $all->merge($records);
        }

        $requests = $all->sortByDesc('created_at')->values();
        $isApprover = in_array(auth()->user()->role, ['gm', 'ceo']);

        return view('admin.payment-approvals.index', compact('requests', 'isApprover'));
    }

    public function approve($id, Request $request)
    {
        $jenis = $request->input('jenis');
        if (! in_array(auth()->user()->role, ['gm', 'ceo'])) {
            return response()->json(['error' => 'Hanya GM dan CEO yang bisa approve.'], 403);
        }

        $class = $this->getModelClass($jenis);
        $record = $class::findOrFail($id);

        if ($record->status !== 'pending') {
            return response()->json(['error' => 'Request sudah diproses.'], 422);
        }

        $record->update([
            'status' => 'lunas',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $detail = $jenis === 'internet' ? $record->nama_internet : $record->periode;
        $jenisLabel = match ($jenis) {
            'internet' => 'Internet',
            'listrik' => 'Listrik',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
        };
        $message = "Pembayaran {$jenisLabel} ({$detail}) telah disetujui oleh ".auth()->user()->name.'.';

        if ($record->requested_by) {
            Notification::send($record->requested_by, 'activity', 'Pembayaran Disetujui', $message, route('payment-approval.status'));
            Cache::forget('tagihan_check_'.$record->requested_by);
        }

        Cache::forget('approval_check_'.auth()->id());

        return response()->json(['success' => true]);
    }

    public function reject($id, Request $request)
    {
        $jenis = $request->input('jenis');
        if (! in_array(auth()->user()->role, ['gm', 'ceo'])) {
            return response()->json(['error' => 'Hanya GM dan CEO yang bisa reject.'], 403);
        }

        $data = $request->validate(['notes' => 'required|string|max:1000']);

        $class = $this->getModelClass($jenis);
        $record = $class::findOrFail($id);

        if ($record->status !== 'pending') {
            return response()->json(['error' => 'Request sudah diproses.'], 422);
        }

        $record->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $data['notes'],
        ]);

        $detail = $jenis === 'internet' ? $record->nama_internet : $record->periode;
        $jenisLabel = match ($jenis) {
            'internet' => 'Internet',
            'listrik' => 'Listrik',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
        };
        $message = "Pembayaran {$jenisLabel} ({$detail}) ditolak. Alasan: {$data['notes']}";

        if ($record->requested_by) {
            Notification::send($record->requested_by, 'activity', 'Pembayaran Ditolak', $message, route('payment-approval.status'));
            Cache::forget('tagihan_check_'.$record->requested_by);
        }

        Cache::forget('approval_check_'.auth()->id());

        return response()->json(['success' => true]);
    }

    public function exportStatus()
    {
        $userId = auth()->id();
        $all = collect();

        foreach ([
            'internet' => WifiPayment::class,
            'listrik' => Payment::class,
            'aset_digital' => PembayaranAsetDigital::class,
            'ipl_ruko' => PembayaranIplRuko::class,
        ] as $jenis => $class) {
            $records = $class::with('requester', 'approver')
                ->where('requested_by', $userId)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($r) => [
                    'No' => null,
                    'Jenis' => match ($jenis) {
                        'internet' => 'Internet',
                        'listrik' => 'Listrik',
                        'aset_digital' => 'Aset Digital',
                        'ipl_ruko' => 'IPL Ruko',
                    },
                    'Detail' => $jenis === 'internet' ? $r->nama_internet : $r->periode,
                    'Nominal' => 'Rp '.number_format((int) ($r->biaya ?? $r->nominal), 0, ',', '.'),
                    'Tgl Bayar' => $r->tanggal_bayar?->format('d/m/Y') ?? '-',
                    'Status' => match ($r->status) {
                        'lunas' => 'Disetujui',
                        'pending' => 'Menunggu',
                        'rejected' => 'Ditolak',
                        default => ucfirst($r->status),
                    },
                    'Bukti' => $r->bukti_bayar ? url('storage/'.$r->bukti_bayar) : '-',
                ]);
            $all = $all->merge($records);
        }

        $data = $all->sortByDesc(fn ($r) => $r['Tgl Bayar'])->values();

        $headings = ['No', 'Jenis', 'Detail', 'Nominal', 'Tgl Bayar', 'Status', 'Bukti'];
        $numbered = $data->map(fn ($r, $i) => array_merge(['No' => $i + 1], array_slice($r, 1)));

        return Excel::download(
            new DataExport($numbered, $headings, 'Status Pengajuan Pembayaran', 'Status', ['Bukti']),
            'Status_Pengajuan_Pembayaran.xlsx'
        );
    }

    private function compressBukti(string $path): void
    {
        $fullPath = Storage::disk('public')->path($path);
        if (!file_exists($fullPath)) return;

        $info = getimagesize($fullPath);
        if (!$info) return;

        [$width, $height] = $info;
        $maxWidth = 1200;

        if ($width <= $maxWidth && filesize($fullPath) <= 204800) return;

        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = (int) ($height * $ratio);
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        $src = match ($info['mime']) {
            'image/jpeg' => @imagecreatefromjpeg($fullPath),
            'image/png' => @imagecreatefrompng($fullPath),
            default => null,
        };

        if (!$src) return;

        $dst = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($dst, $fullPath, 70);
        imagedestroy($src);
        imagedestroy($dst);
    }
}
