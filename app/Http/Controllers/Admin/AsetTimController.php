<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetTim;
use Illuminate\Http\Request;

class AsetTimController extends Controller
{
    public function index(Request $request)
    {
        $activeTim = $request->input('tim');

        $query = AsetTim::with('penanggungJawab');

        if ($activeTim) {
            $query->where('tim', $activeTim);
        }

        $assets = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $assets->count(),
            'aktif' => $assets->where('is_active', true)->count(),
            'nonaktif' => $assets->where('is_active', false)->count(),
        ];

        $allTim = AsetTim::whereNotNull('tim')->where('tim', '!=', '')->distinct()->pluck('tim')->sort()->values();

        $assetsJson = $assets->values()->map(function ($a) {
            return [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'tim' => $a->tim,
                'jumlah' => $a->jumlah,
                'penanggung_jawab' => $a->penanggung_jawab,
                'penanggung_jawab_nama' => $a->penanggungJawab?->name ?? '-',
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keterangan' => $a->keterangan,
                'is_active' => $a->is_active,
            ];
        });

        return view('admin.aset-tim.index', [
            'assets' => $assets,
            'assetsJson' => $assetsJson,
            'stats' => $stats,
            'allTim' => $allTim,
            'activeTim' => $activeTim,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'tim' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data['is_active'] = true;

        $asset = AsetTim::create($data);

        $redirect = $request->input('tim')
            ? route('admin.aset-tim.index', ['tim' => $request->input('tim')])
            : route('admin.aset-tim.index');

        return redirect($redirect)->with('success', 'Aset TIM berhasil ditambahkan.');
    }

    public function update(Request $request, AsetTim $asetTim)
    {
        $rules = [
            'nama_aset' => 'sometimes|required|string|max:255',
            'tim' => 'nullable|string|max:255',
            'jumlah' => 'nullable|integer|min:1',
            'penanggung_jawab' => 'nullable|exists:users,id',
            'pic' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];

        $data = $request->validate($rules);
        $asetTim->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'keterangan' => $asetTim->fresh()->keterangan]);
        }

        $redirect = $request->input('tim')
            ? route('admin.aset-tim.index', ['tim' => $request->input('tim')])
            : route('admin.aset-tim.index');

        return redirect($redirect)->with('success', 'Aset TIM berhasil diperbarui.');
    }

    public function destroy(Request $request, AsetTim $asetTim)
    {
        $tim = $request->input('tim');
        $asetTim->delete();

        $redirect = $tim
            ? route('admin.aset-tim.index', ['tim' => $tim])
            : route('admin.aset-tim.index');

        return redirect($redirect)->with('success', 'Aset TIM berhasil dihapus.');
    }
}
