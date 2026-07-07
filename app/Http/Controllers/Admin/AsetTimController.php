<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTim;
use App\Models\PembayaranAsetTim;
use Illuminate\Http\Request;

class AsetTimController extends Controller
{
    public function index()
    {
        $assets = AsetTim::with('penanggungJawab')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $assets->count(),
            'aktif' => $assets->where('is_active', true)->count(),
            'nonaktif' => $assets->where('is_active', false)->count(),
        ];

        $assetsJson = $assets->values()->map(function ($a) {
            return [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'tim' => $a->tim,
                'jumlah' => $a->jumlah,
                'penanggung_jawab' => $a->penanggung_jawab,
                'penanggung_jawab_nama' => $a->penanggungJawab?->name ?? '-',
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ];
        });

        return view('admin.aset-tim.index', [
            'assets' => $assets,
            'assetsJson' => $assetsJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'tim' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data['is_active'] = true;

        $asset = AsetTim::create($data);

        $jatuhTempo = now()->addDays(30);
        PembayaranAsetTim::create([
            'aset_tim_id' => $asset->id,
            'periode' => $asset->nama_aset,
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => $jatuhTempo->toDateString(),
            'nominal' => 0,
            'status' => 'pending',
            'tanggal_bayar' => null,
        ]);

        return redirect()->route('admin.aset-tim.index')->with('success', 'Aset TIM berhasil ditambahkan.');
    }

    public function update(Request $request, AsetTim $asetTim)
    {
        $rules = [
            'nama_aset' => 'sometimes|required|string|max:255',
            'tim' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];

        $data = $request->validate($rules);
        $asetTim->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'keterangan' => $asetTim->fresh()->keterangan]);
        }

        return redirect()->route('admin.aset-tim.index')->with('success', 'Aset TIM berhasil diperbarui.');
    }

    public function destroy(AsetTim $asetTim)
    {
        $asetTim->delete();

        return redirect()->route('admin.aset-tim.index')->with('success', 'Aset TIM berhasil dihapus.');
    }
}
