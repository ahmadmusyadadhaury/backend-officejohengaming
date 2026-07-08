<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DigitalAsset;
use App\Models\PembayaranAsetDigital;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DigitalAssetApiController extends Controller
{
    public function index()
    {
        $assets = DigitalAsset::orderBy('created_at', 'desc')->get();
        $today = now()->startOfDay();

        $stats = [
            'total' => $assets->count(),
            'aktif' => $assets->filter(fn ($a) => $a->berakhir && $a->berakhir->gte($today))->count(),
            'nonaktif' => $assets->filter(fn ($a) => ! $a->berakhir || $a->berakhir->lt($today))->count(),
        ];

        return response()->json([
            'stats' => $stats,
            'data' => $assets->values()->map(function ($a) use ($today) {
                return [
                    'id' => $a->id,
                    'nama_aset' => $a->nama_aset,
                    'email' => $a->email,
                    'mulai' => $a->mulai?->format('Y-m-d'),
                    'berakhir' => $a->berakhir?->format('Y-m-d'),
                    'biaya' => (float) $a->biaya,
                    'pic' => $a->pic,
                    'jabatan' => $a->jabatan,
                    'keperluan' => $a->keperluan,
                    'is_active' => $a->berakhir && $a->berakhir->gte($today),
                ];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mulai' => 'required|date',
            'berakhir' => 'required|date|after_or_equal:mulai',
            'biaya' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'keperluan' => 'nullable|string',
        ]);

        $data['is_active'] = Carbon::parse($data['berakhir'])->gte(now()->startOfDay());

        $asset = DigitalAsset::create($data);

        $jatuhTempo = now()->addDays(30);
        PembayaranAsetDigital::create([
            'digital_asset_id' => $asset->id,
            'periode' => $asset->nama_aset,
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => $jatuhTempo->toDateString(),
            'nominal' => $asset->biaya,
            'status' => $jatuhTempo->lte(now()->addDays(7)) ? 'jatuh_tempo' : 'pending',
            'tanggal_bayar' => null,
        ]);

        return response()->json([
            'message' => 'Digital Asset created successfully',
            'digital_asset' => $asset->fresh(),
        ], 201);
    }

    public function update(Request $request, DigitalAsset $digitalAsset)
    {
        $data = $request->validate([
            'nama_aset' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'mulai' => 'sometimes|required|date',
            'berakhir' => 'sometimes|required|date|after_or_equal:mulai',
            'biaya' => 'sometimes|required|numeric|min:0',
            'pic' => 'sometimes|required|string|max:255',
            'jabatan' => 'sometimes|required|string|max:255',
            'keperluan' => 'nullable|string',
        ]);

        if (isset($data['berakhir'])) {
            $data['is_active'] = Carbon::parse($data['berakhir'])->gte(now()->startOfDay());
        }

        $digitalAsset->update($data);

        if ($digitalAsset->pembayaran) {
            $sync = [];
            if (isset($data['nama_aset'])) {
                $sync['periode'] = $data['nama_aset'];
            }
            if (isset($data['biaya'])) {
                $sync['nominal'] = $data['biaya'];
            }
            if ($sync) {
                $digitalAsset->pembayaran->update($sync);
            }
        }

        return response()->json([
            'message' => 'Digital Asset updated successfully',
            'digital_asset' => $digitalAsset->fresh(),
        ]);
    }

    public function destroy(DigitalAsset $digitalAsset)
    {
        $digitalAsset->delete();

        return response()->json(['message' => 'Digital Asset deleted successfully']);
    }
}
