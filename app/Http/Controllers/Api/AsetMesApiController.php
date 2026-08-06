<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsetMes;

class AsetMesApiController extends Controller
{
    public function index()
    {
        $assets = AsetMes::with('penanggungJawab')->orderBy('created_at', 'desc')->get();

        return response()->json([
            'data' => $assets->values()->map(fn ($a) => [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'kategori' => $a->kategori,
                'jumlah' => $a->jumlah,
                'penanggung_jawab' => $a->penanggung_jawab,
                'penanggung_jawab_nama' => $a->penanggungJawab?->name ?? '-',
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ]),
        ]);
    }
}
