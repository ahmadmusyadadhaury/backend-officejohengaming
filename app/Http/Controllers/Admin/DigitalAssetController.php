<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DigitalAsset;
use App\Models\PembayaranAsetDigital;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class DigitalAssetController extends Controller
{
    public function index(Request $request)
    {
        $showAll = $request->boolean('show_all');
        $search = trim((string) $request->input('search', ''));
        $status = $request->input('status', '');

        $allAssets = DigitalAsset::orderBy('created_at', 'desc')->get();

        if ($search !== '') {
            $lsearch = strtolower($search);
            $allAssets = $allAssets->filter(fn ($a) => str_contains(strtolower($a->nama_aset ?? ''), $lsearch)
                || str_contains(strtolower($a->pic ?? ''), $lsearch)
            )->values();
        }
        if ($status && $status !== 'all') {
            $allAssets = $allAssets->filter(fn ($a) => $a->status_aset === $status)->values();
        }

        $stats = [
            'total' => $allAssets->count(),
            'aktif' => $allAssets->filter(fn ($a) => $a->status_aset === 'aktif')->count(),
            'jatuh_tempo' => $allAssets->filter(fn ($a) => $a->status_aset === 'jatuh_tempo')->count(),
            'segera_habis' => $allAssets->filter(fn ($a) => $a->status_aset === 'segera_habis')->count(),
            'nonaktif' => $allAssets->filter(fn ($a) => $a->status_aset === 'mati')->count(),
        ];

        $alertAssets = $allAssets->filter(fn ($a) => in_array($a->status_aset, ['jatuh_tempo', 'segera_habis', 'mati']));
        $alertJson = $alertAssets->values()->map(fn ($a) => [
            'id' => $a->id,
            'nama_aset' => $a->nama_aset,
            'berakhir' => $a->berakhir?->format('d/m/Y'),
            'status_aset' => $a->status_aset,
            'hari_aset' => $a->hari_aset,
        ]);

        $perPage = $showAll ? max($allAssets->count(), 1) : 10;
        $page = max(Paginator::resolveCurrentPage('page'), 1);
        $assets = new LengthAwarePaginator(
            $allAssets->forPage($page, $perPage)->values(),
            $allAssets->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $assetsJson = $allAssets->values()->map(function ($a) {
            return [
                'id' => $a->id,
                'nama_aset' => $a->nama_aset,
                'email' => $a->email,
                'mulai' => $a->mulai?->format('d/m/Y'),
                'berakhir' => $a->berakhir?->format('d/m/Y'),
                'biaya' => (int) $a->biaya,
                'pic' => $a->pic,
                'jabatan' => $a->jabatan,
                'keperluan' => $a->keperluan,
                'is_active' => $a->status_aset !== 'mati',
                'status_aset' => $a->status_aset,
                'hari_aset' => $a->hari_aset,
            ];
        });

        return view('admin.digital-assets.index', [
            'assets' => $assets,
            'assetsJson' => $assetsJson,
            'stats' => $stats,
            'alertAssets' => $alertAssets,
            'alertJson' => $alertJson,
            'showAll' => $showAll,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_aset' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mulai' => 'required|date',
            'berakhir' => 'required|date|after_or_equal:mulai',
            'biaya' => 'required|numeric|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'keperluan' => 'nullable|string',
        ]);

        $data['is_active'] = Carbon::parse($data['berakhir'])->gte(now()->startOfDay());

        $asset = DigitalAsset::create($data);

        $berakhir = Carbon::parse($asset->berakhir);
        if ($data['is_active'] && $berakhir->gt(now()->addDays(7))) {
            return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil ditambahkan.');
        }

        $jatuhTempo = now()->addDays(30);
        PembayaranAsetDigital::create([
            'digital_asset_id' => $asset->id,
            'periode' => $asset->nama_aset,
            'tanggal_tagihan' => now()->toDateString(),
            'jatuh_tempo' => $jatuhTempo->toDateString(),
            'nominal' => $asset->biaya,
            'status' => $jatuhTempo->lte(now()->addDays(7)) ? 'jatuh_tempo' : 'pending',
            'tanggal_bayar' => null,
        ]);

        return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil ditambahkan.');
    }

    public function update(Request $request, DigitalAsset $digitalAsset)
    {
        $rules = [
            'nama_aset' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'mulai' => 'sometimes|required|date',
            'berakhir' => 'sometimes|required|date|after_or_equal:mulai',
            'biaya' => 'sometimes|required|numeric|min:0',
            'pic' => 'sometimes|required|string|max:255',
            'jabatan' => 'sometimes|required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'keperluan' => 'nullable|string',
        ];

        $data = $request->validate($rules);

        if (isset($data['berakhir'])) {
            $data['is_active'] = Carbon::parse($data['berakhir'])->gte(now()->startOfDay());
        }

        $digitalAsset->update($data);

        if ($digitalAsset->pembayaran) {
            $sync = [];
            if (isset($data['nama_aset'])) {
                $sync['periode'] = $data['nama_aset'];
            }
            if (isset($data['biaya'])) {
                $sync['nominal'] = $data['biaya'];
            }
            if ($sync) {
                $digitalAsset->pembayaran->update($sync);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'keperluan' => $digitalAsset->fresh()->keperluan]);
        }

        return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil diperbarui.');
    }

    public function destroy(DigitalAsset $digitalAsset)
    {
        $digitalAsset->delete();

        return redirect()->route('admin.digital-assets.index')->with('success', 'Aset digital berhasil dihapus.');
    }
}
