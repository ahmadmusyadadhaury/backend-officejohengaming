<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetDaya;
use App\Models\PembayaranAsetDaya;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AsetDayaController extends Controller
{
    public function index()
    {
        $assets = AsetDaya::with('penanggungJawab')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $assets->count(),
            'aktif' => $assets->where('is_active', true)->count(),
            'nonaktif' => $assets->where('is_active', false)->count(),
        ];

        $assetsJson = $assets->values()->map(function ($a) {
            return [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'daya' => $a->daya,
                'unit' => $a->unit,
                'penanggung_jawab' => $a->penanggung_jawab,
                'penanggung_jawab_nama' => $a->penanggungJawab?->name ?? '-',
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ];
        });

        return view('admin.aset-daya.index', [
            'assets' => $assets,
            'assetsJson' => $assetsJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
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

        return redirect()->route('admin.aset-daya.index')->with('success', 'Aset Daya berhasil ditambahkan.');
    }

    public function update(Request $request, AsetDaya $asetDaya)
    {
        $rules = [
            'nama_aset' => 'sometimes|required|string|max:255',
            'daya' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];

        $data = $request->validate($rules);
        $asetDaya->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'keterangan' => $asetDaya->fresh()->keterangan]);
        }

        return redirect()->route('admin.aset-daya.index')->with('success', 'Aset Daya berhasil diperbarui.');
    }

    public function destroy(AsetDaya $asetDaya)
    {
        $asetDaya->delete();

        return redirect()->route('admin.aset-daya.index')->with('success', 'Aset Daya berhasil dihapus.');
    }
}
