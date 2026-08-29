<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetMes;
use Illuminate\Http\Request;

class AsetMesController extends Controller
{
    public function index(Request $request)
    {
        $searchPutra = trim((string) $request->input('search_putra', ''));
        $searchPutri = trim((string) $request->input('search_putri', ''));

        $baseQuery = AsetMes::with('penanggungJawab')
            ->where('penanggung_jawab', auth()->id());

        $applySearch = function ($q, $search) {
            if ($search !== '') {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nama_aset', 'like', "%{$search}%")
                        ->orWhere('pic', 'like', "%{$search}%");
                });
            }
        };

        $queryPutra = (clone $baseQuery)->where('kategori', 'putra');
        $queryPutri = (clone $baseQuery)->where('kategori', 'putri');
        $applySearch($queryPutra, $searchPutra);
        $applySearch($queryPutri, $searchPutri);

        $assetsPutra = (clone $queryPutra)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_putra')
            ->withQueryString();

        $assetsPutri = (clone $queryPutri)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_putri')
            ->withQueryString();

        $assetsJson = collect([...$assetsPutra->items(), ...$assetsPutri->items()])
            ->map(fn ($a) => [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'kategori' => $a->kategori,
                'jumlah' => $a->jumlah,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ])
            ->values();

        return view('leader.aset-mes.index', [
            'assetsPutra' => $assetsPutra,
            'assetsPutri' => $assetsPutri,
            'assetsJson' => $assetsJson,
            'penanggungJawabMes' => AsetMes::PENANGGUNG_JAWAB_MES,
            'searchPutra' => $searchPutra,
            'searchPutri' => $searchPutri,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|in:putra,putri',
            'jumlah' => 'nullable|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $data['penanggung_jawab'] = auth()->id();
        $data['is_active'] = true;

        AsetMes::create($data);

        return redirect()->route('koordinator.aset-mes.index')->with('success', 'Aset MES berhasil ditambahkan.');
    }

    public function update(Request $request, AsetMes $asetMes)
    {
        if ($asetMes->penanggung_jawab !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'kategori' => 'required|in:putra,putri',
            'jumlah' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        $asetMes->update($data);

        return redirect()->route('koordinator.aset-mes.index')->with('success', 'Aset MES berhasil diperbarui.');
    }

    public function destroy(AsetMes $asetMes)
    {
        if ($asetMes->penanggung_jawab !== auth()->id()) {
            abort(403);
        }

        $asetMes->delete();

        return redirect()->route('koordinator.aset-mes.index')->with('success', 'Aset MES berhasil dihapus.');
    }
}
