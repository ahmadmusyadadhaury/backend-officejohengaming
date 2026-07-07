<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetDaya;
use Illuminate\Http\Request;

class DataSayaController extends Controller
{
    public function index()
    {
        $assets = AsetDaya::with('penanggungJawab')
            ->where('penanggung_jawab', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.data-saya.index', compact('assets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
            'daya' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data['penanggung_jawab'] = auth()->id();
        $data['is_active'] = true;

        AsetDaya::create($data);

        return redirect()->route('koordinator.data-saya.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function update(Request $request, AsetDaya $asetDaya)
    {
        if ($asetDaya->penanggung_jawab !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
            'daya' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        $asetDaya->update($data);

        return redirect()->route('koordinator.data-saya.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(AsetDaya $asetDaya)
    {
        if ($asetDaya->penanggung_jawab !== auth()->id()) {
            abort(403);
        }

        $asetDaya->delete();

        return redirect()->route('koordinator.data-saya.index')->with('success', 'Aset berhasil dihapus.');
    }
}
