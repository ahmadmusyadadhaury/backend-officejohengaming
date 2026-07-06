<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SosialMedia;
use Illuminate\Http\Request;

class SosialMediaController extends Controller
{
    public function index()
    {
        $items = SosialMedia::orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $items->count(),
        ];

        $platformCounts = $items->groupBy('platform')->map->count();
        $stats['platforms'] = $platformCounts;

        $itemsJson = $items->values()->map(function ($i) {
            return [
                'id' => $i->id,
                'username' => $i->username,
                'nama' => $i->nama,
                'followers' => $i->followers,
                'platform' => $i->platform,
                'divisi' => $i->divisi,
                'pic' => $i->pic,
                'ket' => $i->ket,
            ];
        });

        return view('admin.sosial-media.index', [
            'items' => $items,
            'itemsJson' => $itemsJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'followers' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'ket' => 'nullable|string',
        ]);

        SosialMedia::create($data);

        return redirect()->route('admin.sosial-media.index')->with('success', 'Sosial Media berhasil ditambahkan.');
    }

    public function update(Request $request, SosialMedia $sosialMedium)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'followers' => 'nullable|string|max:255',
            'platform' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'pic' => 'required|string|max:255',
            'ket' => 'nullable|string',
        ]);

        $sosialMedium->update($data);

        return redirect()->route('admin.sosial-media.index')->with('success', 'Sosial Media berhasil diperbarui.');
    }

    public function destroy(SosialMedia $sosialMedium)
    {
        $sosialMedium->delete();

        return redirect()->route('admin.sosial-media.index')->with('success', 'Sosial Media berhasil dihapus.');
    }
}
