<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalAsset;
use Illuminate\Http\Request;

class DigitalAssetController extends Controller
{
    public function index()
    {
        $assets = DigitalAsset::orderBy('created_at', 'desc')->get();

        $stats = [
            'total'   => $assets->count(),
            'aktif'   => $assets->where('is_active', true)->count(),
            'nonaktif' => $assets->where('is_active', false)->count(),
        ];

        $assetsJson = $assets->values()->map(function ($a) {
            return [
                'id'        => $a->id,
                'nama_aset' => $a->nama_aset,
                'email'     => $a->email,
                'mulai'     => $a->mulai?->format('d/m/Y'),
                'berakhir'  => $a->berakhir?->format('d/m/Y'),
                'biaya'     => (int) $a->biaya,
                'pic'       => $a->pic,
                'jabatan'   => $a->jabatan,
                'keperluan' => $a->keperluan,
                'is_active' => $a->is_active,
            ];
        });

        return view('admin.digital-assets.index', [
            'assets'     => $assets,
            'assetsJson' => $assetsJson,
            'stats'      => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'mulai'     => 'required|date',
            'berakhir'  => 'required|date|after_or_equal:mulai',
            'biaya'     => 'required|numeric|min:0',
            'pic'       => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'keperluan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        DigitalAsset::create($data);

        return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil ditambahkan.');
    }

    public function update(Request $request, DigitalAsset $digitalAsset)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'mulai'     => 'required|date',
            'berakhir'  => 'required|date|after_or_equal:mulai',
            'biaya'     => 'required|numeric|min:0',
            'pic'       => 'required|string|max:255',
            'jabatan'   => 'required|string|max:255',
            'keperluan' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $digitalAsset->update($data);

        return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil diperbarui.');
    }

    public function destroy(DigitalAsset $digitalAsset)
    {
        $digitalAsset->delete();

        return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil dihapus.');
    }
}
