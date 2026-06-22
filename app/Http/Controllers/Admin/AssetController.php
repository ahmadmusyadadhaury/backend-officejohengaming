<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assetStats = [
            'total_assets' => Asset::count(),
            'pajak_aktif'  => Asset::whereNull('expire_date')->orWhere('expire_date', '>=', now())->count(),
            'pajak_mati'   => Asset::where('expire_date', '<', now())->count(),
        ];

        return view('admin.assets.index', [
            'assets' => Asset::paginate(15),
            'assetStats' => $assetStats,
        ]);
    }

    public function create()
    {
        return view('admin.assets.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'quantity' => 'required|integer|min:1']);
        Asset::create($request->only('name', 'description', 'quantity') + ['is_active' => true]);

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function edit(Asset $asset)
    {
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $request->validate(['name' => 'required|string|max:255', 'quantity' => 'required|integer|min:1']);
        $asset->update($request->only('name', 'description', 'quantity', 'is_active'));

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
