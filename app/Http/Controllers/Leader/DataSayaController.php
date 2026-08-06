<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetSaya;
use Illuminate\Http\Request;

class DataSayaController extends Controller
{
    public function index()
    {
        $assets = AsetSaya::where('penanggung_jawab', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('leader.data-saya.index', compact('assets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'daya' => 'nullable|string|max:255',
        ]);

        $data['penanggung_jawab'] = auth()->id();
        $data['is_active'] = true;

        AsetSaya::create($data);

        return redirect()->route('koordinator.data-saya.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function update(Request $request, AsetSaya $asetSaya)
    {
        $data = $request->validate([
            'nama_aset' => 'sometimes|required|string|max:255',
            'jenis_aset' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'daya' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $asetSaya->update($data);

        return redirect()->route('koordinator.data-saya.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(AsetSaya $asetSaya)
    {
        $asetSaya->delete();

        return redirect()->route('koordinator.data-saya.index')->with('success', 'Aset berhasil dihapus.');
    }
}
