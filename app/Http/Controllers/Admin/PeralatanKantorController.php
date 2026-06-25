<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeralatanKantor;
use Illuminate\Http\Request;

class PeralatanKantorController extends Controller
{
    public function index()
    {
        $items = PeralatanKantor::orderBy('created_at', 'desc')->get();

        $stats = [
            'total'        => $items->count(),
            'kondisi_baik' => $items->where('kondisi', 'baik')->count(),
            'perlu_servis' => $items->where('kondisi', 'perlu_servis')->count(),
            'rusak'        => $items->where('kondisi', 'rusak')->count(),
        ];

        $itemsJson = $items->values()->map(function ($i) {
            return [
                'id'                       => $i->id,
                'nama_barang'              => $i->nama_barang,
                'jumlah'                   => $i->jumlah,
                'detail'                   => $i->detail,
                'sub_kategori'             => $i->sub_kategori,
                'keterangan'               => $i->keterangan,
                'lokasi_unit'              => $i->lokasi_unit,
                'ruangan'                  => $i->ruangan,
                'milik'                    => $i->milik,
                'pengadaan_tahun'          => $i->pengadaan_tahun,
                'tanggal_pembelian'        => $i->tanggal_pembelian?->format('Y-m-d'),
                'kategori_nilai'           => $i->kategori_nilai,
                'kategori_ukuran'          => $i->kategori_ukuran,
                'nilai'                    => (int) $i->nilai,
                'waktu_pakai_per_hari'     => $i->waktu_pakai_per_hari,
                'estimasi_waktu_barang'    => $i->estimasi_waktu_barang,
                'pengurangan_harga_per_hari' => (int) $i->pengurangan_harga_per_hari,
                'harga_per_hari_ini'       => (int) $i->harga_per_hari_ini,
                'pic'                      => $i->pic,
                'jabatan'                  => $i->jabatan,
                'atasan'                   => $i->atasan,
                'jabatan_atasan'           => $i->jabatan_atasan,
                'kondisi'                  => $i->kondisi,
            ];
        });

        return view('admin.peralatan-kantor.index', [
            'items'     => $items,
            'itemsJson' => $itemsJson,
            'stats'     => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_barang'              => 'required|string|max:255',
            'jumlah'                   => 'required|integer|min:1',
            'detail'                   => 'nullable|string',
            'sub_kategori'             => 'required|string|max:255',
            'keterangan'               => 'nullable|string',
            'lokasi_unit'              => 'required|string|max:255',
            'ruangan'                  => 'required|string|max:255',
            'milik'                    => 'required|string|max:255',
            'pengadaan_tahun'          => 'required|integer|min:1900|max:' . (now()->year + 1),
            'tanggal_pembelian'        => 'required|date',
            'kategori_nilai'           => 'required|string|max:255',
            'kategori_ukuran'          => 'required|string|max:255',
            'nilai'                    => 'required|numeric|min:0',
            'waktu_pakai_per_hari'     => 'required|integer|min:0',
            'estimasi_waktu_barang'    => 'required|integer|min:0',
            'pengurangan_harga_per_hari' => 'required|numeric|min:0',
            'harga_per_hari_ini'       => 'required|numeric|min:0',
            'pic'                      => 'required|string|max:255',
            'jabatan'                  => 'required|string|max:255',
            'atasan'                   => 'required|string|max:255',
            'jabatan_atasan'           => 'required|string|max:255',
            'kondisi'                  => 'required|string|in:baik,perlu_servis,rusak',
        ]);

        PeralatanKantor::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Peralatan kantor berhasil ditambahkan.'], 201);
        }

        return redirect()->route('admin.peralatan-kantor.index')->with('success', 'Peralatan kantor berhasil ditambahkan.');
    }

    public function update(Request $request, PeralatanKantor $peralatanKantor)
    {
        $data = $request->validate([
            'nama_barang'              => 'required|string|max:255',
            'jumlah'                   => 'required|integer|min:1',
            'detail'                   => 'nullable|string',
            'sub_kategori'             => 'required|string|max:255',
            'keterangan'               => 'nullable|string',
            'lokasi_unit'              => 'required|string|max:255',
            'ruangan'                  => 'required|string|max:255',
            'milik'                    => 'required|string|max:255',
            'pengadaan_tahun'          => 'required|integer|min:1900|max:' . (now()->year + 1),
            'tanggal_pembelian'        => 'required|date',
            'kategori_nilai'           => 'required|string|max:255',
            'kategori_ukuran'          => 'required|string|max:255',
            'nilai'                    => 'required|numeric|min:0',
            'waktu_pakai_per_hari'     => 'required|integer|min:0',
            'estimasi_waktu_barang'    => 'required|integer|min:0',
            'pengurangan_harga_per_hari' => 'required|numeric|min:0',
            'harga_per_hari_ini'       => 'required|numeric|min:0',
            'pic'                      => 'required|string|max:255',
            'jabatan'                  => 'required|string|max:255',
            'atasan'                   => 'required|string|max:255',
            'jabatan_atasan'           => 'required|string|max:255',
            'kondisi'                  => 'required|string|in:baik,perlu_servis,rusak',
        ]);

        $peralatanKantor->update($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Peralatan kantor berhasil diperbarui.']);
        }

        return redirect()->route('admin.peralatan-kantor.index')->with('success', 'Peralatan kantor berhasil diperbarui.');
    }

    public function destroy(PeralatanKantor $peralatanKantor)
    {
        $peralatanKantor->delete();

        return redirect()->route('admin.peralatan-kantor.index')->with('success', 'Peralatan kantor berhasil dihapus.');
    }
}
