<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetMes;
use App\Models\PembayaranAsetMes;
use Illuminate\Http\Request;

class AsetMesController extends Controller
{
    public function index()
    {
        $assets = AsetMes::with('penanggungJawab')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $assets->count(),
            'aktif' => $assets->where('is_active', true)->count(),
            'nonaktif' => $assets->where('is_active', false)->count(),
        ];

        $assetsJson = $assets->values()->map(function ($a) {
            return [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'jumlah' => $a->jumlah,
                'penanggung_jawab' => $a->penanggung_jawab,
                'penanggung_jawab_nama' => $a->penanggungJawab?->name ?? '-',
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ];
        });

        return view('admin.aset-mes.index', [
            'assets' => $assets,
            'assetsJson' => $assetsJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data['is_active'] = true;

        $asset = AsetMes::create($data);

        $jatuhTempo = now()->addDays(30);
        PembayaranAsetMes::create([
            'aset_mes_id' => $asset->id,
            'periode' => $asset->nama_aset,
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => $jatuhTempo->toDateString(),
            'nominal' => 0,
            'status' => 'pending',
            'tanggal_bayar' => null,
        ]);

        return redirect()->route('admin.aset-mes.index')->with('success', 'Aset MES berhasil ditambahkan.');
    }

    public function update(Request $request, AsetMes $asetMes)
    {
        $rules = [
            'nama_aset' => 'sometimes|required|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];

        $data = $request->validate($rules);
        $asetMes->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'keterangan' => $asetMes->fresh()->keterangan]);
        }

        return redirect()->route('admin.aset-mes.index')->with('success', 'Aset MES berhasil diperbarui.');
    }

    public function destroy(AsetMes $asetMes)
    {
        $asetMes->delete();

        return redirect()->route('admin.aset-mes.index')->with('success', 'Aset MES berhasil dihapus.');
    }
}
