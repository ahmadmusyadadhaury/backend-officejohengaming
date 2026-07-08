<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PeralatanKantor;

class PeralatanKantorApiController extends Controller
{
    public function index()
    {
        $items = PeralatanKantor::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $items->map(function ($i) {
                $masaBarang = max($i->estimasi_waktu_barang ?: 360, 1);
                $penyusutanPerHari = $i->nilai / $masaBarang;
                $hariTerpakai = $i->tanggal_pembelian ? max(abs(now()->diffInDays($i->tanggal_pembelian)), 0) : 0;
                $nilaiSekarang = max($i->nilai - ($penyusutanPerHari * $hariTerpakai), 0);

                return [
                    'id' => $i->id,
                    'nama_barang' => $i->nama_barang,
                    'pic' => $i->pic,
                    'lokasi_unit' => $i->lokasi_unit,
                    'nilai_sekarang' => round($nilaiSekarang, 2),
                    'kondisi' => $i->kondisi,
                ];
            }),
        ]);
    }
}
