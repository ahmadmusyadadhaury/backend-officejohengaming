<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ElectricityTokenReading;
use App\Models\InternetUsageCheck;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranAsetTim;
use App\Models\PembayaranIplRuko;
use App\Models\TokenPayment;
use App\Models\WifiPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembayaranApiController extends Controller
{
    private function resolvePaymentStatus($dueDate): string
    {
        $today = Carbon::today();
        $due = $dueDate instanceof Carbon ? $dueDate : Carbon::parse($dueDate);

        return $due->lte($today->copy()->addDays(7)) ? 'jatuh_tempo' : 'pending';
    }

    public function index(Request $request)
    {
        $jenis = $request->get('jenis', 'internet');
        $items = collect();
        $stats = ['total' => 0, 'aktif' => 0, 'jatuh_tempo' => 0, 'terlambat' => 0];

        $today = Carbon::today();
        $sevenDays = $today->copy()->addDays(7);

        if ($jenis === 'internet') {
            $all = WifiPayment::orderBy('created_at', 'desc')->get();
            $stats = [
                'total' => $all->count(),
                'aktif' => $all->where('status', 'lunas')->count(),
                'jatuh_tempo' => $all->filter(fn ($w) => is_null($w->requested_by) && ! in_array($w->status, ['lunas', 'rejected']) && $w->masa_tenggang && $w->masa_tenggang <= $sevenDays && $w->masa_tenggang >= $today)->count(),
                'terlambat' => $all->filter(fn ($w) => is_null($w->requested_by) && ! in_array($w->status, ['lunas', 'rejected']) && $w->masa_tenggang && $w->masa_tenggang < $today)->count(),
            ];
            $items = $all->values()->map(fn ($w) => [
                'id' => $w->id,
                'nama_internet' => $w->nama_internet,
                'provider' => $w->provider,
                'pic' => $w->pic,
                'jabatan' => $w->jabatan,
                'masa_tenggang' => $w->masa_tenggang?->format('Y-m-d'),
                'biaya' => (float) $w->biaya,
                'status' => $w->status,
                'tanggal_bayar' => $w->tanggal_bayar?->format('Y-m-d'),
                'requested_by' => $w->requested_by,
                'approved_by' => $w->approved_by,
                'bukti_bayar' => $w->bukti_bayar,
                'notes' => $w->notes,
            ]);
        } elseif ($jenis === 'aset_digital') {
            $all = PembayaranAsetDigital::orderBy('created_at', 'desc')->get();
            $stats = $this->paymentStats($all, 'jatuh_tempo');
            $items = $all->values()->map(fn ($p) => $this->paymentItem($p, 'aset_digital'));
        } elseif ($jenis === 'ipl_ruko') {
            $all = PembayaranIplRuko::orderBy('created_at', 'desc')->get();
            $stats = $this->paymentStats($all, 'jatuh_tempo');
            $items = $all->values()->map(fn ($p) => $this->paymentItem($p, 'ipl_ruko'));
        } elseif ($jenis === 'aset_tim') {
            $all = PembayaranAsetTim::orderBy('created_at', 'desc')->get();
            $stats = $this->paymentStats($all, 'jatuh_tempo');
            $items = $all->values()->map(fn ($p) => $this->paymentItem($p, 'aset_tim'));
        } else {
            $all = collect();
            $stats = ['total' => 0, 'aktif' => 0, 'jatuh_tempo' => 0, 'terlambat' => 0];
            $items = collect();
        }

        return response()->json([
            'jenis' => $jenis,
            'stats' => $stats,
            'data' => $items,
        ]);
    }

    public function indexTokenTopups()
    {
        $topups = TokenPayment::with('creator')
            ->orderBy('payment_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $topups->values()->map(fn ($t) => [
                'id' => $t->id,
                'amount_kwh' => (float) $t->amount_kwh,
                'nominal' => (float) $t->nominal,
                'payment_date' => $t->payment_date?->format('Y-m-d'),
                'period' => $t->period,
                'notes' => $t->notes,
                'bukti_bayar' => $t->bukti_bayar,
                'creator_name' => $t->creator?->name,
            ]),
        ]);
    }

    public function indexTokenReadings()
    {
        $readings = ElectricityTokenReading::with('checker')
            ->orderBy('checked_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $readings->values()->map(fn ($r) => [
                'id' => $r->id,
                'remaining_kwh' => (float) $r->remaining_kwh,
                'status' => $r->status,
                'checked_date' => $r->checked_date?->format('Y-m-d'),
                'notes' => $r->notes,
                'checker_name' => $r->checker?->name,
            ]),
        ]);
    }

    public function indexInternetPayments()
    {
        $payments = WifiPayment::with('requester')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $payments->values()->map(fn ($w) => [
                'id' => $w->id,
                'nama_internet' => $w->nama_internet,
                'provider' => $w->provider,
                'pic' => $w->pic,
                'jabatan' => $w->jabatan,
                'masa_tenggang' => $w->masa_tenggang?->format('Y-m-d'),
                'biaya' => (float) $w->biaya,
                'status' => $w->status,
                'status_internet' => $w->status_internet,
                'hari_internet' => $w->hari_internet,
                'tanggal_bayar' => $w->tanggal_bayar?->format('Y-m-d'),
                'period' => $w->period,
                'notes' => $w->notes,
                'bukti_bayar' => $w->bukti_bayar,
                'creator_name' => $w->requester?->name,
            ]),
        ]);
    }

    public function indexInternetChecks()
    {
        $checks = InternetUsageCheck::with('checker')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $checks->values()->map(fn ($u) => [
                'id' => $u->id,
                'ruangan' => $u->ruangan,
                'hari' => $u->hari,
                'tanggal' => $u->tanggal?->format('Y-m-d'),
                'penggunaan_wifi' => (float) $u->penggunaan_wifi,
                'penggunaan_ethernet' => (float) $u->penggunaan_ethernet,
                'keterangan' => $u->keterangan,
                'checker_name' => $u->checker?->name,
            ]),
        ]);
    }

    public function indexDigitalAssetPayments()
    {
        $payments = PembayaranAsetDigital::with('digitalAsset')
            ->with('requester')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $payments->values()->map(fn ($p) => [
                'id' => $p->id,
                'digital_asset_id' => $p->digital_asset_id,
                'nama_aset' => $p->digitalAsset?->nama_aset,
                'email' => $p->digitalAsset?->email,
                'periode' => $p->periode,
                'tanggal_tagihan' => $p->tanggal_tagihan?->format('Y-m-d'),
                'jatuh_tempo' => $p->jatuh_tempo?->format('Y-m-d'),
                'nominal' => (float) $p->nominal,
                'status' => $p->status,
                'status_digital' => $p->status_digital,
                'hari_digital' => $p->hari_digital,
                'tanggal_bayar' => $p->tanggal_bayar?->format('Y-m-d'),
                'period' => $p->period,
                'notes' => $p->notes,
                'bukti_bayar' => $p->bukti_bayar,
                'pic' => $p->pic,
                'jabatan' => $p->jabatan,
                'creator_name' => $p->requester?->name,
            ]),
        ]);
    }

    public function indexIplRukoPayments()
    {
        $payments = PembayaranIplRuko::with('requester')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => $payments->values()->map(fn ($p) => [
                'id' => $p->id,
                'periode' => $p->periode,
                'tanggal_tagihan' => $p->tanggal_tagihan?->format('Y-m-d'),
                'jatuh_tempo' => $p->jatuh_tempo?->format('Y-m-d'),
                'nominal' => (float) $p->nominal,
                'pic' => $p->pic,
                'jabatan' => $p->jabatan,
                'status' => $p->status,
                'status_ipl' => $p->status_ipl,
                'hari_ipl' => $p->hari_ipl,
                'tanggal_bayar' => $p->tanggal_bayar?->format('Y-m-d'),
                'period' => $p->period,
                'notes' => $p->notes,
                'bukti_bayar' => $p->bukti_bayar,
                'creator_name' => $p->requester?->name,
            ]),
        ]);
    }

    public function indexTagihan()
    {
        $all = collect();

        $internet = WifiPayment::with('requester')
            ->whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected', 'menunggu'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'internet',
                'jenis_label' => 'Internet',
                'detail' => $r->nama_internet,
                'nominal' => (float) ($r->biaya ?? 0),
                'status' => $r->status_internet,
                'hari' => $r->hari_internet,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'jatuh_tempo' => $r->masa_tenggang?->format('Y-m-d'),
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'notes' => $r->notes,
                'bukti_bayar' => $r->bukti_bayar,
                'creator_name' => $r->requester?->name,
            ]);
        $all = $all->merge($internet);

        $digital = PembayaranAsetDigital::with('requester')
            ->whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected', 'menunggu'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'aset_digital',
                'jenis_label' => 'Aset Digital',
                'detail' => $r->periode,
                'nominal' => (float) ($r->nominal ?? 0),
                'status' => $r->status_digital,
                'hari' => $r->hari_digital,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'jatuh_tempo' => $r->jatuh_tempo?->format('Y-m-d'),
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'notes' => $r->notes,
                'bukti_bayar' => $r->bukti_bayar,
                'creator_name' => $r->requester?->name,
            ]);
        $all = $all->merge($digital);

        $ipl = PembayaranIplRuko::with('requester')
            ->whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected', 'menunggu'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'ipl_ruko',
                'jenis_label' => 'IPL Ruko',
                'detail' => $r->periode,
                'nominal' => (float) ($r->nominal ?? 0),
                'status' => $r->status_ipl,
                'hari' => $r->hari_ipl,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'jatuh_tempo' => $r->jatuh_tempo?->format('Y-m-d'),
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'notes' => $r->notes,
                'bukti_bayar' => $r->bukti_bayar,
                'creator_name' => $r->requester?->name,
            ]);
        $all = $all->merge($ipl);

        $asetTim = PembayaranAsetTim::with('requester')
            ->whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected', 'menunggu'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'aset_tim',
                'jenis_label' => 'Aset TIM',
                'detail' => $r->periode,
                'nominal' => (float) ($r->nominal ?? 0),
                'status' => $r->status,
                'hari' => null,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'jatuh_tempo' => $r->jatuh_tempo?->format('Y-m-d'),
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'notes' => $r->notes,
                'bukti_bayar' => $r->bukti_bayar,
                'creator_name' => $r->requester?->name,
            ]);
        $all = $all->merge($asetTim);

        return response()->json([
            'data' => $all->values(),
        ]);
    }

    public function indexPengajuan()
    {
        $all = collect();

        $internet = WifiPayment::with('requester', 'approver')
            ->whereNotNull('requested_by')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'internet',
                'jenis_label' => 'Internet',
                'detail' => $r->nama_internet,
                'nominal' => (float) ($r->biaya ?? 0),
                'status' => $r->status,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'period' => $r->period ?? 'bulanan',
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'bukti_bayar' => $r->bukti_bayar,
                'requester_name' => $r->requester?->name,
                'approver_name' => $r->approver?->name,
                'approved_at' => $r->approved_at?->format('Y-m-d H:i:s'),
                'notes' => $r->notes,
                'created_at' => $r->created_at->format('Y-m-d H:i:s'),
            ]);
        $all = $all->merge($internet);

        $digital = PembayaranAsetDigital::with('requester', 'approver')
            ->whereNotNull('requested_by')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'aset_digital',
                'jenis_label' => 'Aset Digital',
                'detail' => $r->periode,
                'nominal' => (float) ($r->nominal ?? 0),
                'status' => $r->status,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'period' => $r->period ?? 'bulanan',
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'bukti_bayar' => $r->bukti_bayar,
                'requester_name' => $r->requester?->name,
                'approver_name' => $r->approver?->name,
                'approved_at' => $r->approved_at?->format('Y-m-d H:i:s'),
                'notes' => $r->notes,
                'created_at' => $r->created_at->format('Y-m-d H:i:s'),
            ]);
        $all = $all->merge($digital);

        $ipl = PembayaranIplRuko::with('requester', 'approver')
            ->whereNotNull('requested_by')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'ipl_ruko',
                'jenis_label' => 'IPL Ruko',
                'detail' => $r->periode,
                'nominal' => (float) ($r->nominal ?? 0),
                'status' => $r->status,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'period' => $r->period ?? 'bulanan',
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'bukti_bayar' => $r->bukti_bayar,
                'requester_name' => $r->requester?->name,
                'approver_name' => $r->approver?->name,
                'approved_at' => $r->approved_at?->format('Y-m-d H:i:s'),
                'notes' => $r->notes,
                'created_at' => $r->created_at->format('Y-m-d H:i:s'),
            ]);
        $all = $all->merge($ipl);

        $asetTim = PembayaranAsetTim::with('requester', 'approver')
            ->whereNotNull('requested_by')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'jenis' => 'aset_tim',
                'jenis_label' => 'Aset TIM',
                'detail' => $r->periode,
                'nominal' => (float) ($r->nominal ?? 0),
                'status' => $r->status,
                'pic' => $r->pic,
                'jabatan' => $r->jabatan,
                'period' => $r->period ?? 'bulanan',
                'tgl_bayar' => $r->tanggal_bayar?->format('Y-m-d'),
                'bukti_bayar' => $r->bukti_bayar,
                'requester_name' => $r->requester?->name,
                'approver_name' => $r->approver?->name,
                'approved_at' => $r->approved_at?->format('Y-m-d H:i:s'),
                'notes' => $r->notes,
                'created_at' => $r->created_at->format('Y-m-d H:i:s'),
            ]);
        $all = $all->merge($asetTim);

        return response()->json([
            'data' => $all->values(),
        ]);
    }

    public function store(Request $request)
    {
        $jenis = $request->input('jenis', 'internet');

        if ($jenis === 'internet') {
            $data = $request->validate([
                'nama_internet' => 'required|string|max:255',
                'provider' => 'required|string|max:255',
                'pic' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'masa_tenggang' => 'required|date',
                'biaya' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $data['status'] = $this->resolvePaymentStatus($data['masa_tenggang']);
            $record = WifiPayment::create($data);
        } elseif ($jenis === 'aset_digital') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $data['status'] = $this->resolvePaymentStatus($data['jatuh_tempo']);
            $record = PembayaranAsetDigital::create($data);
        } elseif ($jenis === 'ipl_ruko') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $data['status'] = $this->resolvePaymentStatus($data['jatuh_tempo']);
            $record = PembayaranIplRuko::create($data);
        } elseif ($jenis === 'aset_tim') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $data['status'] = $this->resolvePaymentStatus($data['jatuh_tempo']);
            $record = PembayaranAsetTim::create($data);
        } else {
            return response()->json(['message' => 'Jenis tidak valid'], 400);
        }

        return response()->json([
            'message' => 'Payment created successfully',
            'data' => $record->fresh(),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $jenis = $request->input('jenis');

        if ($jenis === 'internet') {
            $data = $request->validate([
                'nama_internet' => 'required|string|max:255',
                'provider' => 'required|string|max:255',
                'pic' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'masa_tenggang' => 'required|date',
                'biaya' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $model = WifiPayment::findOrFail($id);
            $data['status'] = $this->resolvePaymentStatus($data['masa_tenggang']);
            $model->update($data);
        } elseif ($jenis === 'aset_digital') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $model = PembayaranAsetDigital::findOrFail($id);
            $data['status'] = $this->resolvePaymentStatus($data['jatuh_tempo']);
            $model->update($data);
        } elseif ($jenis === 'ipl_ruko') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $model = PembayaranIplRuko::findOrFail($id);
            $data['status'] = $this->resolvePaymentStatus($data['jatuh_tempo']);
            $model->update($data);
        } elseif ($jenis === 'aset_tim') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'tanggal_bayar' => 'nullable|date',
            ]);
            $model = PembayaranAsetTim::findOrFail($id);
            $data['status'] = $this->resolvePaymentStatus($data['jatuh_tempo']);
            $model->update($data);
        } else {
            return response()->json(['message' => 'Jenis tidak valid'], 400);
        }

        if ($request->input('status') === 'lunas') {
            $class = match ($jenis) {
                'internet' => WifiPayment::class,
                'aset_digital' => PembayaranAsetDigital::class,
                'ipl_ruko' => PembayaranIplRuko::class,
                'aset_tim' => PembayaranAsetTim::class,
                default => WifiPayment::class,
            };
            $record = $class::findOrFail($id);

            $updateData = [
                'status' => 'pending',
                'requested_by' => auth()->id(),
                'tanggal_bayar' => $request->input('tanggal_bayar', now()),
                'period' => $request->input('period', 'bulanan'),
            ];

            $record->update($updateData);

            return response()->json([
                'message' => 'Payment submitted for approval',
                'data' => $record->fresh(),
            ]);
        }

        return response()->json([
            'message' => 'Payment updated successfully',
            'data' => $model->fresh(),
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $jenis = $request->input('jenis', 'internet');

        $model = match ($jenis) {
            'internet' => WifiPayment::findOrFail($id),
            'aset_digital' => PembayaranAsetDigital::findOrFail($id),
            'ipl_ruko' => PembayaranIplRuko::findOrFail($id),
            'aset_tim' => PembayaranAsetTim::findOrFail($id),
            default => abort(400, 'Jenis tidak valid'),
        };

        $model->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }

    public function storeBulkIplRuko(Request $request)
    {
        $data = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2040',
            'nominal' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $tahun = (int) $data['tahun'];
        $now = now();
        $bulanIndonesia = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $created = 0;
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $tanggalAkhir = Carbon::create($tahun, $bulan)->endOfMonth();
            $jatuhTempo = $tanggalAkhir->copy();
            $status = ($tahun < $now->year || ($tahun === $now->year && $bulan < $now->month)) ? 'jatuh_tempo' : 'pending';

            $exists = PembayaranIplRuko::whereYear('tanggal_tagihan', $tahun)
                ->whereMonth('tanggal_tagihan', $bulan)->exists();

            if (! $exists) {
                PembayaranIplRuko::create([
                    'periode' => $bulanIndonesia[$bulan].' '.$tahun,
                    'tanggal_tagihan' => $tanggalAkhir,
                    'jatuh_tempo' => $jatuhTempo,
                    'nominal' => $data['nominal'],
                    'pic' => $data['pic'],
                    'jabatan' => $data['jabatan'],
                    'status' => $status,
                ]);
                $created++;
            }
        }

        return response()->json(['message' => "Berhasil menambahkan {$created} tagihan IPL Ruko tahun {$tahun}."]);
    }

    public function bulkIpl(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|integer|min:2020|max:2035',
            'nominal' => 'required|numeric|min:0',
        ]);

        $year = (int) $data['year'];
        $nominal = (float) $data['nominal'];
        $now = now();
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        $created = 0;
        $skipped = 0;

        foreach ($months as $month => $monthName) {
            $periode = $monthName.' '.$year;
            if (PembayaranIplRuko::where('periode', $periode)->exists()) {
                $skipped++;

                continue;
            }

            $lastDay = Carbon::create($year, $month)->daysInMonth;
            $tglTagihan = Carbon::create($year, $month, min(30, $lastDay));
            $tglJatuhTempo = Carbon::create($year, $month, min(22, $lastDay));
            $isFuture = $year > $now->year || ($year === $now->year && $month > $now->month);
            $status = $isFuture ? 'pending' : 'jatuh_tempo';

            PembayaranIplRuko::create([
                'periode' => $periode,
                'tanggal_tagihan' => $tglTagihan,
                'jatuh_tempo' => $tglJatuhTempo,
                'nominal' => $nominal,
                'status' => $status,
            ]);
            $created++;
        }

        return response()->json([
            'message' => "Berhasil membuat {$created} tagihan IPL untuk tahun {$year}.",
            'skipped' => $skipped,
        ]);
    }

    public function storeTokenReading(Request $request)
    {
        $data = $request->validate([
            'remaining_kwh' => 'required|numeric|min:0|max:99999',
            'checked_date' => 'required|date',
            'checked_by' => 'required|exists:users,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $remaining = $data['remaining_kwh'];
        $data['status'] = match (true) {
            $remaining < 500 => 'segera_isi',
            $remaining < 1000 => 'warning',
            $remaining < 2000 => 'perhatian',
            default => 'aman',
        };

        $reading = ElectricityTokenReading::create($data);

        return response()->json([
            'message' => 'Token reading saved successfully',
            'data' => $reading->fresh(),
        ], 201);
    }

    public function destroyTokenReading($id)
    {
        ElectricityTokenReading::findOrFail($id)->delete();

        return response()->json(['message' => 'Token reading deleted successfully']);
    }

    public function storeTokenPayment(Request $request)
    {
        $data = $request->validate([
            'amount_kwh' => 'required|numeric|min:1',
            'nominal' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $data['period'] = Carbon::parse($data['payment_date'])->format('Y-m');
        $data['created_by'] = auth()->id();

        $payment = TokenPayment::create($data);

        return response()->json([
            'message' => 'Token topup saved successfully',
            'data' => $payment->fresh(),
        ], 201);
    }

    public function destroyTokenPayment($id)
    {
        TokenPayment::findOrFail($id)->delete();

        return response()->json(['message' => 'Token topup deleted successfully']);
    }

    public function storeInternetUsage(Request $request)
    {
        $data = $request->validate([
            'ruangan' => 'required|string|max:255',
            'hari' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'penggunaan_wifi' => 'required|numeric|min:0',
            'penggunaan_ethernet' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data['checked_by'] = auth()->id();
        $usage = InternetUsageCheck::create($data);

        return response()->json([
            'message' => 'Internet usage saved successfully',
            'data' => $usage->fresh(),
        ], 201);
    }

    public function destroyInternetUsage($id)
    {
        InternetUsageCheck::findOrFail($id)->delete();

        return response()->json(['message' => 'Internet usage deleted successfully']);
    }

    private function paymentStats($collection, string $dateField): array
    {
        $today = Carbon::today();
        $sevenDays = $today->copy()->addDays(7);

        return [
            'total' => $collection->count(),
            'aktif' => $collection->where('status', 'lunas')->count(),
            'jatuh_tempo' => $collection->filter(fn ($p) => is_null($p->requested_by) && ! in_array($p->status, ['lunas', 'rejected']) && $p->{$dateField} && $p->{$dateField} <= $sevenDays && $p->{$dateField} >= $today)->count(),
            'terlambat' => $collection->filter(fn ($p) => is_null($p->requested_by) && ! in_array($p->status, ['lunas', 'rejected']) && $p->{$dateField} && $p->{$dateField} < $today)->count(),
        ];
    }

    private function paymentItem($p, string $jenis): array
    {
        $item = [
            'id' => $p->id,
            'periode' => $p->periode,
            'tanggal_tagihan' => $p->tanggal_tagihan?->format('Y-m-d'),
            'jatuh_tempo' => $p->jatuh_tempo?->format('Y-m-d'),
            'nominal' => (float) $p->nominal,
            'status' => $p->status,
            'tanggal_bayar' => $p->tanggal_bayar?->format('Y-m-d'),
            'requested_by' => $p->requested_by,
            'approved_by' => $p->approved_by,
            'bukti_bayar' => $p->bukti_bayar,
            'notes' => $p->notes,
            'pic' => $p->pic ?? null,
            'jabatan' => $p->jabatan ?? null,
        ];

        if ($jenis === 'aset_digital') {
            $item['digital_asset_id'] = $p->digital_asset_id;
        } elseif ($jenis === 'aset_tim') {
            $item['aset_tim_id'] = $p->aset_tim_id;
        }

        return $item;
    }
}
