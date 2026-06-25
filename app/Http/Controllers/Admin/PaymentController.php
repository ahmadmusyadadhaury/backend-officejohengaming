<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TokenLowMail;
use App\Models\ElectricityTokenReading;
use App\Models\Payment;
use App\Models\PembayaranAsetDigital;
use App\Models\PembayaranIplRuko;
use App\Models\TokenPayment;
use App\Models\User;
use App\Models\WifiPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->get('jenis', 'internet');

        if ($jenis === 'internet') {
            $items = WifiPayment::orderBy('created_at', 'desc')->get();
            $all = WifiPayment::all();

            $stats = [
                'total' => $all->count(),
                'aktif' => $all->where('status', 'lunas')->count(),
                'jatuh_tempo' => $all->filter(fn ($w) => $w->status === 'jatuh_tempo' && ($w->masa_tenggang >= today()))->count(),
                'terlambat' => $all->filter(fn ($w) => $w->status === 'jatuh_tempo' && $w->masa_tenggang < today())->count(),
            ];

            $itemsJson = $items->values()->map(function ($w) {
                return [
                    'id' => $w->id,
                    'nama_internet' => $w->nama_internet,
                    'provider' => $w->provider,
                    'pic' => $w->pic,
                    'jabatan' => $w->jabatan,
                    'masa_tenggang' => $w->masa_tenggang?->format('Y-m-d'),
                    'biaya' => (float) $w->biaya,
                    'status' => $w->status,
                    'tanggal_bayar' => $w->tanggal_bayar?->format('Y-m-d'),
                ];
            });

            $alertItems = $all->filter(fn ($w) => $w->status === 'jatuh_tempo')->values();
        } elseif ($jenis === 'aset_digital') {
            $items = PembayaranAsetDigital::orderBy('created_at', 'desc')->get();
            $all = PembayaranAsetDigital::all();

            $stats = [
                'total' => $all->count(),
                'aktif' => $all->where('status', 'lunas')->count(),
                'jatuh_tempo' => $all->filter(fn ($p) => $p->status === 'jatuh_tempo' && $p->jatuh_tempo >= today())->count(),
                'terlambat' => $all->filter(fn ($p) => $p->status === 'jatuh_tempo' && $p->jatuh_tempo < today())->count(),
            ];

            $itemsJson = $items->values()->map(fn ($p) => [
                'id' => $p->id,
                'periode' => $p->periode,
                'tanggal_tagihan' => $p->tanggal_tagihan?->format('Y-m-d'),
                'jatuh_tempo' => $p->jatuh_tempo?->format('Y-m-d'),
                'nominal' => (float) $p->nominal,
                'status' => $p->status,
                'tanggal_bayar' => $p->tanggal_bayar?->format('Y-m-d'),
            ]);

            $alertItems = $all->filter(fn ($p) => $p->status === 'jatuh_tempo')->values();
        } elseif ($jenis === 'ipl_ruko') {
            $items = PembayaranIplRuko::orderBy('created_at', 'desc')->get();
            $all = PembayaranIplRuko::all();

            $stats = [
                'total' => $all->count(),
                'aktif' => $all->where('status', 'lunas')->count(),
                'jatuh_tempo' => $all->filter(fn ($p) => $p->status === 'jatuh_tempo' && $p->jatuh_tempo >= today())->count(),
                'terlambat' => $all->filter(fn ($p) => $p->status === 'jatuh_tempo' && $p->jatuh_tempo < today())->count(),
            ];

            $itemsJson = $items->values()->map(fn ($p) => [
                'id' => $p->id,
                'periode' => $p->periode,
                'tanggal_tagihan' => $p->tanggal_tagihan?->format('Y-m-d'),
                'jatuh_tempo' => $p->jatuh_tempo?->format('Y-m-d'),
                'nominal' => (float) $p->nominal,
                'status' => $p->status,
                'tanggal_bayar' => $p->tanggal_bayar?->format('Y-m-d'),
            ]);

            $alertItems = $all->filter(fn ($p) => $p->status === 'jatuh_tempo')->values();
        } else {
            $items = Payment::where('jenis', 'listrik')->orderBy('created_at', 'desc')->get();
            $all = Payment::where('jenis', 'listrik')->get();

            $stats = [
                'total' => $all->count(),
                'aktif' => $all->where('status', 'lunas')->count(),
                'jatuh_tempo' => $all->filter(fn ($p) => $p->status === 'jatuh_tempo' && $p->jatuh_tempo >= today())->count(),
                'terlambat' => $all->filter(fn ($p) => $p->status === 'jatuh_tempo' && $p->jatuh_tempo < today())->count(),
            ];

            $itemsJson = $items->values()->map(function ($p) {
                return [
                    'id' => $p->id,
                    'periode' => $p->periode,
                    'tanggal_tagihan' => $p->tanggal_tagihan?->format('Y-m-d'),
                    'jatuh_tempo' => $p->jatuh_tempo?->format('Y-m-d'),
                    'nominal' => (float) $p->nominal,
                    'status' => $p->status,
                    'tanggal_bayar' => $p->tanggal_bayar?->format('Y-m-d'),
                ];
            });

            $alertItems = $all->filter(fn ($p) => $p->status === 'jatuh_tempo')->values();
        }

        $tokenReadings = collect();
        $latestReading = null;
        $tokenAlert = null;
        $capacityKwh = 7000;
        $usedKwh = 0;
        $tokenMonth = now()->format('Y-m');
        $latestPayment = null;
        $topupHistory = collect();
        $topupRange = $request->get('topup_range', 'bulanan');
        $readingRange = $request->get('reading_range', 'bulanan');

        if ($jenis === 'listrik') {
            $tokenMonth = $request->get('token_month', now()->format('Y-m'));
            $startDate = Carbon::parse($tokenMonth.'-01')->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();

            $tokenReadings = ElectricityTokenReading::with('checker')
                ->whereBetween('checked_date', [$startDate, $endDate])
                ->orderBy('checked_date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            $latestPayment = TokenPayment::with('creator')
                ->orderBy('payment_date', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            $topupQuery = TokenPayment::with('creator');
            if ($topupRange === 'harian') {
                $topupQuery->whereDate('payment_date', Carbon::today());
            } elseif ($topupRange === 'mingguan') {
                $topupQuery->whereBetween('payment_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            }
            $topupHistory = $topupQuery->orderBy('payment_date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            $capacityKwh = $latestPayment ? (float) $latestPayment->amount_kwh : 7000;

            $latestReadingAfterTopup = null;
            if ($latestPayment) {
                $latestReadingAfterTopup = ElectricityTokenReading::with('checker')
                    ->where('checked_date', '>=', $latestPayment->payment_date)
                    ->orderBy('checked_date', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();
            }

            if ($latestReadingAfterTopup) {
                $latestReading = $latestReadingAfterTopup;
                $usedKwh = $capacityKwh - (float) $latestReading->remaining_kwh;
            } else {
                $latestReading = null;
                $usedKwh = 0;
            }

            $tokenAlert = null;
            if ($latestReading && $latestReading->remaining_kwh < 500) {
                $tokenAlert = [
                    'level' => 'danger',
                    'message' => "Sisa token listrik tinggal {$latestReading->remaining_kwh} KWH! Segera lakukan pembayaran token.",
                ];
            } elseif ($latestReading && $latestReading->remaining_kwh < 1000) {
                $tokenAlert = [
                    'level' => 'warning',
                    'message' => "Sisa token listrik {$latestReading->remaining_kwh} KWH. Segera persiapkan pembayaran token.",
                ];
            } elseif ($latestReading && $latestReading->remaining_kwh < 2000) {
                $tokenAlert = [
                    'level' => 'info',
                    'message' => "Sisa token listrik {$latestReading->remaining_kwh} KWH. Lakukan pengecekan rutin setiap minggu.",
                ];
            } elseif (! $latestReading && $latestPayment) {
                $tokenAlert = [
                    'level' => 'info',
                    'message' => 'Belum ada pengecekan setelah top-up terakhir. Lakukan pengecekan setiap minggu.',
                ];
            } elseif (! $latestPayment) {
                $tokenAlert = [
                    'level' => 'warning',
                    'message' => 'Belum ada top up token. Silakan lakukan top up terlebih dahulu.',
                ];
            }
        }

        $jenisLabels = [
            'internet' => 'Internet',
            'listrik' => 'Listrik',
            'aset_digital' => 'Aset Digital',
            'ipl_ruko' => 'IPL Ruko',
        ];

        $jenisIcons = [
            'internet' => 'M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M3.5 13.58a10.5 10.5 0 0117 0',
            'listrik' => 'M13 10V3L4 14h7v7l9-11h-7z',
            'aset_digital' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z',
            'ipl_ruko' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        ];

        $users = User::orderBy('name')->get();

        return view('admin.pembayaran.index', compact(
            'jenis', 'items', 'itemsJson', 'stats', 'alertItems',
            'jenisLabels', 'jenisIcons', 'tokenReadings', 'latestReading',
            'tokenAlert', 'capacityKwh', 'usedKwh', 'tokenMonth',
            'latestPayment', 'topupHistory', 'topupRange', 'readingRange',
            'users'
        ));
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
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            WifiPayment::create($data);
        } elseif ($jenis === 'aset_digital') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            PembayaranAsetDigital::create($data);
        } elseif ($jenis === 'ipl_ruko') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            PembayaranIplRuko::create($data);
        } else {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            $data['jenis'] = $jenis;
            Payment::create($data);
        }

        return redirect()->route('admin.pembayaran.index', ['jenis' => $jenis])
            ->with('success', 'Tagihan berhasil ditambahkan.');
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
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            if (!empty($data['masa_tenggang'])) {
                $data['masa_tenggang'] = \Carbon\Carbon::parse($data['masa_tenggang'])->format('Y-m-d');
            }
            if (!empty($data['tanggal_bayar'])) {
                $data['tanggal_bayar'] = \Carbon\Carbon::parse($data['tanggal_bayar'])->format('Y-m-d');
            }
            $model = WifiPayment::findOrFail($id);
            $model->update($data);
        } elseif ($jenis === 'aset_digital') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            if (!empty($data['tanggal_tagihan'])) {
                $data['tanggal_tagihan'] = \Carbon\Carbon::parse($data['tanggal_tagihan'])->format('Y-m-d');
            }
            if (!empty($data['jatuh_tempo'])) {
                $data['jatuh_tempo'] = \Carbon\Carbon::parse($data['jatuh_tempo'])->format('Y-m-d');
            }
            if (!empty($data['tanggal_bayar'])) {
                $data['tanggal_bayar'] = \Carbon\Carbon::parse($data['tanggal_bayar'])->format('Y-m-d');
            }
            $model = PembayaranAsetDigital::findOrFail($id);
            $model->update($data);
        } elseif ($jenis === 'ipl_ruko') {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            if (!empty($data['tanggal_tagihan'])) {
                $data['tanggal_tagihan'] = \Carbon\Carbon::parse($data['tanggal_tagihan'])->format('Y-m-d');
            }
            if (!empty($data['jatuh_tempo'])) {
                $data['jatuh_tempo'] = \Carbon\Carbon::parse($data['jatuh_tempo'])->format('Y-m-d');
            }
            if (!empty($data['tanggal_bayar'])) {
                $data['tanggal_bayar'] = \Carbon\Carbon::parse($data['tanggal_bayar'])->format('Y-m-d');
            }
            $model = PembayaranIplRuko::findOrFail($id);
            $model->update($data);
        } else {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            if (!empty($data['tanggal_tagihan'])) {
                $data['tanggal_tagihan'] = \Carbon\Carbon::parse($data['tanggal_tagihan'])->format('Y-m-d');
            }
            if (!empty($data['jatuh_tempo'])) {
                $data['jatuh_tempo'] = \Carbon\Carbon::parse($data['jatuh_tempo'])->format('Y-m-d');
            }
            if (!empty($data['tanggal_bayar'])) {
                $data['tanggal_bayar'] = \Carbon\Carbon::parse($data['tanggal_bayar'])->format('Y-m-d');
            }
            $model = Payment::findOrFail($id);
            $model->update($data);
        }

        return redirect()->route('admin.pembayaran.index', ['jenis' => $jenis])
            ->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $jenis = $request->input('jenis', 'internet');

        if ($jenis === 'internet') {
            $model = WifiPayment::findOrFail($id);
        } elseif ($jenis === 'aset_digital') {
            $model = PembayaranAsetDigital::findOrFail($id);
        } elseif ($jenis === 'ipl_ruko') {
            $model = PembayaranIplRuko::findOrFail($id);
        } else {
            $model = Payment::findOrFail($id);
        }
        $model->delete();

        return redirect()->route('admin.pembayaran.index', ['jenis' => $jenis])
            ->with('success', 'Tagihan berhasil dihapus.');
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

        ElectricityTokenReading::create($data);

        $recipients = array_map('trim', explode(',', (string) env('TOKEN_LOW_EMAIL_RECIPIENTS', '')));
        $recipients = array_filter($recipients);

        if ($remaining < 500 && $recipients) {
            foreach ($recipients as $email) {
                Mail::to($email)->send(new TokenLowMail($remaining, 'danger'));
            }
        } elseif ($remaining < 1000 && $recipients) {
            foreach ($recipients as $email) {
                Mail::to($email)->send(new TokenLowMail($remaining, 'warning'));
            }
        }

        return redirect()->route('admin.pembayaran.index', ['jenis' => 'listrik'])
            ->with('success', 'Pengecekan token berhasil disimpan. Sisa: '.$remaining.' KWH.');
    }

    public function destroyTokenReading($id)
    {
        $reading = ElectricityTokenReading::findOrFail($id);
        $reading->delete();

        return redirect()->route('admin.pembayaran.index', ['jenis' => 'listrik'])
            ->with('success', 'Data pengecekan token berhasil dihapus.');
    }

    public function storeTokenPayment(Request $request)
    {
        $data = $request->validate([
            'amount_kwh' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $data['period'] = Carbon::parse($data['payment_date'])->format('Y-m');
        $data['created_by'] = auth()->id();

        TokenPayment::create($data);

        return redirect()->route('admin.pembayaran.index', ['jenis' => 'listrik'])
            ->with('success', 'Top up token sebanyak '.number_format($data['amount_kwh'], 0).' KWH berhasil disimpan.');
    }

    public function destroyTokenPayment($id)
    {
        $payment = TokenPayment::findOrFail($id);
        $payment->delete();

        return redirect()->route('admin.pembayaran.index', ['jenis' => 'listrik'])
            ->with('success', 'Riwayat top up token berhasil dihapus.');
    }
}
