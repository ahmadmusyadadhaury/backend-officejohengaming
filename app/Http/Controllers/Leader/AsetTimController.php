<?php

namespace App\Http\Controllers\Leader;

use App\Http\Controllers\Controller;
use App\Models\AsetTim;
use App\Models\Team;
use Illuminate\Http\Request;

class AsetTimController extends Controller
{
    public function index()
    {
        $assets = AsetTim::with('penanggungJawab')
            ->where('penanggung_jawab', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $allTim = Team::where('is_active', true)->pluck('name')
            ->merge(AsetTim::whereNotNull('tim')->where('tim', '!=', '')->distinct()->pluck('tim'))
            ->unique()->sort()->values();

        $userTim = auth()->user()->team?->name;

        return view('leader.aset-tim.index', compact('assets', 'allTim', 'userTim'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $data['jumlah'] = $data['jumlah'] ?? 1;
        $data['tim'] = auth()->user()->team?->name;
        $data['penanggung_jawab'] = auth()->id();
        $data['is_active'] = true;

        AsetTim::create($data);

        return redirect()->route('koordinator.aset-tim.index')->with('success', 'Aset TIM berhasil ditambahkan.');
    }

    public function update(Request $request, AsetTim $asetTim)
    {
        if ($asetTim->penanggung_jawab !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        $data['jumlah'] = $data['jumlah'] ?? 1;
        $data['tim'] = auth()->user()->team?->name;
        $asetTim->update($data);

        return redirect()->route('koordinator.aset-tim.index')->with('success', 'Aset TIM berhasil diperbarui.');
    }

    public function destroy(AsetTim $asetTim)
    {
        if ($asetTim->penanggung_jawab !== auth()->id()) {
            abort(403);
        }

        $asetTim->delete();

        return redirect()->route('koordinator.aset-tim.index')->with('success', 'Aset TIM berhasil dihapus.');
    }
}
