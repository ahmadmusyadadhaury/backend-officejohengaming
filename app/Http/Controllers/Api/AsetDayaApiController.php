<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsetDaya;
use App\Models\PembayaranAsetDaya;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsetDayaApiController extends Controller
{
    public function index()
    {
        $assets = AsetDaya::with('penanggungJawab')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $assets->count(),
            'aktif' => $assets->where('is_active', true)->count(),
            'nonaktif' => $assets->where('is_active', false)->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'data' => $assets->values()->map(fn ($a) => [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'jenis_aset' => $a->jenis_aset,
                'daya' => $a->daya,
                'unit' => $a->unit,
                'penanggung_jawab' => $a->penanggung_jawab,
                'penanggung_jawab_nama' => $a->penanggungJawab?->name ?? '-',
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
            'daya' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data['is_active'] = true;

        $asset = AsetDaya::create($data);

        $jatuhTempo = now()->addDays(30);
        PembayaranAsetDaya::create([
            'aset_daya_id' => $asset->id,
            'periode' => $asset->nama_aset,
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => $jatuhTempo->toDateString(),
            'nominal' => 0,
            'status' => 'pending',
            'tanggal_bayar' => null,
        ]);

        return response()->json([
            'message' => 'Aset Daya created successfully',
            'aset_daya' => $asset->fresh()->load('penanggungJawab'),
        ], 201);
    }

    public function update(Request $request, AsetDaya $asetDaya)
    {
        $data = $request->validate([
            'nama_aset' => 'sometimes|required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
            'daya' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $asetDaya->update($data);

        return response()->json([
            'message' => 'Aset Daya updated successfully',
            'aset_daya' => $asetDaya->fresh()->load('penanggungJawab'),
        ]);
    }

    public function destroy(AsetDaya $asetDaya)
    {
        $asetDaya->delete();

        return response()->json(['message' => 'Aset Daya deleted successfully']);
    }
}
