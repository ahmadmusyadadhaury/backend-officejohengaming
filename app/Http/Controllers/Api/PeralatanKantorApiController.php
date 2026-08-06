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
                    'kode_aset' => $i->kode_aset,
                    'barcode' => $i->barcode,
                    'foto' => $i->foto,
                    'nama_barang' => $i->nama_barang,
                    'jumlah' => (int) $i->jumlah,
                    'detail' => $i->detail,
                    'sub_kategori' => $i->sub_kategori,
                    'keterangan' => $i->keterangan,
                    'lokasi_unit' => $i->lokasi_unit,
                    'ruangan' => $i->ruangan,
                    'milik' => $i->milik,
                    'pengadaan_tahun' => $i->pengadaan_tahun,
                    'tanggal_pembelian' => $i->tanggal_pembelian?->format('Y-m-d'),
                    'kategori_nilai' => $i->kategori_nilai,
                    'kategori_ukuran' => $i->kategori_ukuran,
                    'nilai' => (float) $i->nilai,
                    'waktu_pakai_per_hari' => (int) $i->waktu_pakai_per_hari,
                    'estimasi_waktu_barang' => (int) $i->estimasi_waktu_barang,
                    'pengurangan_harga_per_hari' => (float) $i->pengurangan_harga_per_hari,
                    'harga_per_hari_ini' => (float) $i->harga_per_hari_ini,
                    'nilai_sekarang' => round($nilaiSekarang, 2),
                    'pic' => $i->pic,
                    'jabatan' => $i->jabatan,
                    'atasan' => $i->atasan,
                    'jabatan_atasan' => $i->jabatan_atasan,
                    'kondisi' => $i->kondisi,
                ];
            }),
        ]);
    }
}
