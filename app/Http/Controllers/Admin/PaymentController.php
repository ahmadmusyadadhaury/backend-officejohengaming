<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TokenLowMail;
use App\Models\ElectricityTokenReading;
use App\Models\Payment;
use App\Models\WifiPayment;
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
        } else {
            $items = Payment::orderBy('created_at', 'desc')->get();
            $all = Payment::all();

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

        if ($jenis === 'listrik') {
            $tokenReadings = ElectricityTokenReading::with('checker')
                ->orderBy('checked_date', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            $latestReading = $tokenReadings->first();

            $capacityKwh = 500;
            $usedKwh = $latestReading ? $capacityKwh - $latestReading->remaining_kwh : 0;

            if ($latestReading && $latestReading->remaining_kwh < 50) {
                $tokenAlert = [
                    'level' => 'danger',
                    'message' => "Sisa token listrik tinggal {$latestReading->remaining_kwh} KWH! Segera lakukan pembayaran token.",
                ];
            } elseif ($latestReading && $latestReading->remaining_kwh < 100) {
                $tokenAlert = [
                    'level' => 'warning',
                    'message' => "Sisa token listrik {$latestReading->remaining_kwh} KWH. Segera persiapkan pembayaran token.",
                ];
            } elseif ($latestReading && $latestReading->remaining_kwh < 200) {
                $tokenAlert = [
                    'level' => 'info',
                    'message' => "Sisa token listrik {$latestReading->remaining_kwh} KWH. Lakukan pengecekan rutin setiap hari Senin.",
                ];
            } elseif (! $latestReading) {
                $tokenAlert = [
                    'level' => 'warning',
                    'message' => 'Belum ada pengecekan token listrik. Lakukan pengecekan setiap hari Senin.',
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

        return view('admin.pembayaran.index', compact('jenis', 'items', 'itemsJson', 'stats', 'alertItems', 'jenisLabels', 'jenisIcons', 'tokenReadings', 'latestReading', 'tokenAlert', 'capacityKwh', 'usedKwh'));
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
        } else {
            $data = $request->validate([
                'periode' => 'required|string|max:255',
                'tanggal_tagihan' => 'required|date',
                'jatuh_tempo' => 'required|date|after_or_equal:tanggal_tagihan',
                'nominal' => 'required|numeric|min:0',
                'status' => 'required|in:lunas,jatuh_tempo',
                'tanggal_bayar' => 'nullable|date|required_if:status,lunas',
            ]);
            Payment::create($data);
        }

        return redirect()->route('admin.pembayaran.index', ['jenis' => $jenis])
            ->with('success', 'Data berhasil ditambahkan.');
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
            $model = WifiPayment::findOrFail($id);
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
            $model = Payment::findOrFail($id);
            $model->update($data);
        }

        return redirect()->route('admin.pembayaran.index', ['jenis' => $jenis])
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $jenis = $request->input('jenis', 'internet');

        if ($jenis === 'internet') {
            $model = WifiPayment::findOrFail($id);
        } else {
            $model = Payment::findOrFail($id);
        }
        $model->delete();

        return redirect()->route('admin.pembayaran.index', ['jenis' => $jenis])
            ->with('success', 'Data berhasil dihapus.');
    }

    public function storeTokenReading(Request $request)
    {
        $data = $request->validate([
            'remaining_kwh' => 'required|numeric|min:0|max:9999',
            'checked_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $data['checked_by'] = auth()->id();

        $remaining = $data['remaining_kwh'];
        $data['status'] = match (true) {
            $remaining < 50 => 'kritis',
            $remaining < 100 => 'warning',
            $remaining < 200 => 'perhatian',
            default => 'aman',
        };

        ElectricityTokenReading::create($data);

        if ($remaining < 50) {
            $recipients = array_map('trim', explode(',', (string) env('TOKEN_LOW_EMAIL_RECIPIENTS', '')));
            $recipients = array_filter($recipients);
            foreach ($recipients as $email) {
                Mail::to($email)->send(new TokenLowMail($remaining));
            }
        }

        return redirect()->route('admin.pembayaran.index', ['jenis' => 'listrik'])
            ->with('success', 'Data pengecekan token berhasil disimpan.');
    }

    public function destroyTokenReading($id)
    {
        $reading = ElectricityTokenReading::findOrFail($id);
        $reading->delete();

        return redirect()->route('admin.pembayaran.index', ['jenis' => 'listrik'])
            ->with('success', 'Data pengecekan token berhasil dihapus.');
    }
}
