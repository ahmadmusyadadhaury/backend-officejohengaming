<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AsetRuko;
use Illuminate\Http\Request;

class AsetRukoApiController extends Controller
{
    public function index()
    {
        $assets = AsetRuko::orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $assets->count(),
            'baik' => $assets->where('kondisi', 'baik')->count(),
            'perlu_servis' => $assets->where('kondisi', 'perlu_servis')->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'data' => $assets->values()->map(fn ($a) => [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'lokasi' => $a->lokasi,
                'jumlah' => $a->jumlah,
                'kondisi' => $a->kondisi,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|in:baik,perlu_servis',
        ]);

        $asset = AsetRuko::create($data);

        return response()->json([
            'message' => 'Aset Ruko created successfully',
            'aset_ruko' => $asset,
        ], 201);
    }

    public function update(Request $request, AsetRuko $ruko)
    {
        $data = $request->validate([
            'nama_aset' => 'sometimes|required|string|max:255',
            'lokasi' => 'sometimes|required|string|max:255',
            'jumlah' => 'sometimes|required|integer|min:1',
            'kondisi' => 'sometimes|required|in:baik,perlu_servis',
        ]);

        $ruko->update($data);

        return response()->json([
            'message' => 'Aset Ruko updated successfully',
            'aset_ruko' => $ruko->fresh(),
        ]);
    }

    public function destroy(AsetRuko $ruko)
    {
        $ruko->delete();

        return response()->json(['message' => 'Aset Ruko deleted successfully']);
    }
}
