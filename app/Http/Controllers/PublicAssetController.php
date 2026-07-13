<?php

namespace App\Http\Controllers;

use App\Models\PeralatanKantor;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicAssetController extends Controller
{
    public function show(string $kode_aset)
    {
        $item = PeralatanKantor::where('kode_aset', $kode_aset)->first();

        if (! $item) {
            return response()->view('public.asset-404', [], 404);
        }

        $fotoUrl = $item->foto ? route('files.show', 'peralatan-kantor/'.$item->foto) : null;

        $statusMap = [
            'baik' => ['label' => 'Aktif', 'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.12)', 'border' => 'rgba(16,185,129,0.3)'],
            'perlu_servis' => ['label' => 'Dipinjam', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.12)', 'border' => 'rgba(245,158,11,0.3)'],
            'rusak' => ['label' => 'Rusak', 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.12)', 'border' => 'rgba(239,68,68,0.3)'],
        ];
        $status = $statusMap[$item->kondisi] ?? ['label' => 'Tidak Aktif', 'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.12)', 'border' => 'rgba(107,114,128,0.3)'];

        $qrUrl = route('public.asset.show', $item->kode_aset);

        return view('public.asset-detail', [
            'item' => $item,
            'fotoUrl' => $fotoUrl,
            'status' => $status,
            'qrUrl' => $qrUrl,
        ]);
    }

    public function qrCode(string $kode_aset): Response
    {
        $item = PeralatanKantor::where('kode_aset', $kode_aset)->first();

        if (! $item) {
            abort(404);
        }

        $url = route('public.asset.show', $item->kode_aset);
        $svg = QrCode::size(300)->generate($url);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
