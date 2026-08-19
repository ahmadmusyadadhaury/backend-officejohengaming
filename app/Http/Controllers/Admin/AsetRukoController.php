<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetRuko;
use Illuminate\Http\Request;

class AsetRukoController extends Controller
{
    public function index()
    {
        $allItems = AsetRuko::orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $allItems->count(),
            'kondisi_baik' => $allItems->where('kondisi', 'baik')->count(),
            'perlu_servis' => $allItems->where('kondisi', 'perlu_servis')->count(),
        ];

        $alertJson = $allItems->where('kondisi', 'perlu_servis')->values()->map(fn ($i) => [
            'id' => $i->id,
            'nama_aset' => $i->nama_aset,
            'lokasi' => $i->lokasi,
            'jumlah' => $i->jumlah,
            'kondisi' => $i->kondisi,
        ]);

        $items = AsetRuko::orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $itemsJson = $items->getCollection()->values()->map(function ($i) {
            return [
                'id' => $i->id,
                'nama_aset' => $i->nama_aset,
                'lokasi' => $i->lokasi,
                'jumlah' => $i->jumlah,
                'kondisi' => $i->kondisi,
            ];
        });

        return view('admin.ruko.index', [
            'items' => $items,
            'itemsJson' => $itemsJson,
            'alertJson' => $alertJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|in:baik,perlu_servis',
        ]);

        AsetRuko::create($data);

        return redirect()->route('admin.ruko.index')->with('success', 'Aset ruko berhasil ditambahkan.');
    }

    public function update(Request $request, AsetRuko $ruko)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|in:baik,perlu_servis',
        ]);

        $ruko->update($data);

        return redirect()->route('admin.ruko.index')->with('success', 'Aset ruko berhasil diperbarui.');
    }

    public function destroy(AsetRuko $ruko)
    {
        $ruko->delete();

        return redirect()->route('admin.ruko.index')->with('success', 'Aset ruko berhasil dihapus.');
    }
}
