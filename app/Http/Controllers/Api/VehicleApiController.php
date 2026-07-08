<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleApiController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $vehicles->map(fn ($v) => [
                'id' => $v->id,
                'nama_kendaraan' => $v->nama_kendaraan,
                'jenis_kendaraan' => $v->jenis_kendaraan,
                'merk_tipe' => $v->merk_tipe,
                'plat_nomor' => $v->plat_nomor,
                'tahun' => $v->tahun,
                'warna' => $v->warna,
                'nomor_rangka' => $v->nomor_rangka,
                'nomor_mesin' => $v->nomor_mesin,
                'foto' => $v->foto,
                'pajak_tahunan' => $v->pajak_tahunan?->format('Y-m-d'),
                'pajak_5_tahun' => $v->pajak_5_tahun?->format('Y-m-d'),
                'kepemilikan_status' => $v->kepemilikan_status,
                'biaya_kendaraan' => (float) $v->biaya_kendaraan,
                'pic' => $v->pic,
                'jabatan' => $v->jabatan,
                'keperluan' => $v->keperluan,
                'status_pajak' => $v->status_pajak,
            ]),
        ]);
    }
}
