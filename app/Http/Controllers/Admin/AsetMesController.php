<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetMes;
use Illuminate\Http\Request;

class AsetMesController extends Controller
{
    public function index(Request $request)
    {
        $showAllPutra = $request->boolean('show_all_putra');
        $showAllPutri = $request->boolean('show_all_putri');

        $countPutra = AsetMes::where('kategori', 'putra')->count();
        $countPutri = AsetMes::where('kategori', 'putri')->count();

        $assetsPutra = AsetMes::with('penanggungJawab')
            ->where('kategori', 'putra')
            ->orderBy('created_at', 'desc')
            ->paginate($showAllPutra ? max($countPutra, 1) : 10, ['*'], 'page_putra')
            ->withQueryString();

        $assetsPutri = AsetMes::with('penanggungJawab')
            ->where('kategori', 'putri')
            ->orderBy('created_at', 'desc')
            ->paginate($showAllPutri ? max($countPutri, 1) : 10, ['*'], 'page_putri')
            ->withQueryString();

        $stats = [
            'total' => AsetMes::count(),
            'aktif' => AsetMes::where('is_active', true)->count(),
            'nonaktif' => AsetMes::where('is_active', false)->count(),
            'putra' => $countPutra,
            'putri' => $countPutri,
        ];

        $assetsJson = collect([...$assetsPutra->items(), ...$assetsPutri->items()])
            ->map(fn ($a) => [
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
            ])
            ->values();

        return view('admin.aset-mes.index', [
            'assetsPutra' => $assetsPutra,
            'assetsPutri' => $assetsPutri,
            'assetsJson' => $assetsJson,
            'stats' => $stats,
            'penanggungJawabMes' => AsetMes::PENANGGUNG_JAWAB_MES,
            'showAllPutra' => $showAllPutra,
            'showAllPutri' => $showAllPutri,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|in:putra,putri',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data['is_active'] = true;

        $asset = AsetMes::create($data);

        return redirect()->route('admin.aset-mes.index')->with('success', 'Aset MES berhasil ditambahkan.');
    }

    public function update(Request $request, AsetMes $asetMes)
    {
        $rules = [
            'nama_aset' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|in:putra,putri',
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
