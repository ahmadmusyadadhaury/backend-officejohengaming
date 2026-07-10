<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PeralatanKantorTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\PeralatanKantorImport;
use App\Models\PeralatanKantor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PeralatanKantorController extends Controller
{
    public function index()
    {
        $items = PeralatanKantor::orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $items->count(),
            'kondisi_baik' => $items->where('kondisi', 'baik')->count(),
            'perlu_servis' => $items->where('kondisi', 'perlu_servis')->count(),
            'rusak' => $items->where('kondisi', 'rusak')->count(),
        ];

        $itemsJson = $items->values()->map(function ($i) {
            $masaBarang = max($i->estimasi_waktu_barang ?: 360, 1);
            $penyusutanPerHari = $i->nilai / $masaBarang;
            $hariTerpakai = $i->tanggal_pembelian ? max(abs(now()->diffInDays($i->tanggal_pembelian)), 0) : 0;
            $nilaiSekarang = max($i->nilai - ($penyusutanPerHari * $hariTerpakai), 0);

            return [
                'id' => $i->id,
                'kode_aset' => $i->kode_aset,
                'barcode' => $i->barcode,
                'nama_barang' => $i->nama_barang,
                'jumlah' => $i->jumlah,
                'detail' => $i->detail,
                'sub_kategori' => $i->sub_kategori,
                'keterangan' => $i->keterangan,
                'lokasi_unit' => $i->lokasi_unit,
                'ruangan' => $i->ruangan,
                'milik' => $i->milik,
                'pengadaan_tahun' => $i->pengadaan_tahun,
                'tanggal_pembelian' => $i->tanggal_pembelian?->format('Y-m-d'),
                'kategori_nilai' => $i->kategori_nilai,
                'kategori_ukuran' => $i->kategori_ukuran,
                'nilai' => (int) $i->nilai,
                'waktu_pakai_per_hari' => $i->waktu_pakai_per_hari,
                'estimasi_waktu_barang' => $i->estimasi_waktu_barang,
                'pengurangan_harga_per_hari' => round($penyusutanPerHari, 2),
                'harga_per_hari_ini' => round($nilaiSekarang, 2),
                'hari_terpakai' => $hariTerpakai,
                'penyusutan_per_hari' => round($penyusutanPerHari, 2),
                'nilai_sekarang' => round($nilaiSekarang, 2),
                'pic' => $i->pic,
                'jabatan' => $i->jabatan,
                'atasan' => $i->atasan,
                'jabatan_atasan' => $i->jabatan_atasan,
                'kondisi' => $i->kondisi,
            ];
        });

        return view('admin.peralatan-kantor.index', [
            'items' => $items,
            'itemsJson' => $itemsJson,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_aset' => 'nullable|string|max:255|unique:peralatan_kantor,kode_aset',
            'barcode' => 'nullable|string|max:255|unique:peralatan_kantor,barcode',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'detail' => 'nullable|string',
            'sub_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'lokasi_unit' => 'required|string|max:255',
            'ruangan' => 'required|string|max:255',
            'milik' => 'required|string|max:255',
            'pengadaan_tahun' => 'required|integer|min:1900|max:'.(now()->year + 1),
            'tanggal_pembelian' => 'required|date',
            'kategori_nilai' => 'required|string|max:255',
            'kategori_ukuran' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0',
            'waktu_pakai_per_hari' => 'required|integer|min:0',
            'estimasi_waktu_barang' => 'required|integer|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'atasan' => 'required|string|max:255',
            'jabatan_atasan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'kondisi' => 'required|string|in:baik,perlu_servis,rusak',
        ]);

        $masaBarang = max($data['estimasi_waktu_barang'], 1);
        $data['pengurangan_harga_per_hari'] = $data['nilai'] / $masaBarang;
        $hariTerpakai = max(abs(now()->diffInDays(Carbon::parse($data['tanggal_pembelian']))), 0);
        $data['harga_per_hari_ini'] = max($data['nilai'] - ($data['pengurangan_harga_per_hari'] * $hariTerpakai), 0);

        $item = PeralatanKantor::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Peralatan kantor berhasil ditambahkan.', 'data' => $item], 201);
        }

        return redirect()->route('admin.peralatan-kantor.index')->with('success', 'Peralatan kantor berhasil ditambahkan.');
    }

    public function update(Request $request, PeralatanKantor $peralatanKantor)
    {
        $data = $request->validate([
            'kode_aset' => 'required|string|max:255|unique:peralatan_kantor,kode_aset,'.$peralatanKantor->id,
            'barcode' => 'required|string|max:255|unique:peralatan_kantor,barcode,'.$peralatanKantor->id,
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'detail' => 'nullable|string',
            'sub_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'lokasi_unit' => 'required|string|max:255',
            'ruangan' => 'required|string|max:255',
            'milik' => 'required|string|max:255',
            'pengadaan_tahun' => 'required|integer|min:1900|max:'.(now()->year + 1),
            'tanggal_pembelian' => 'required|date',
            'kategori_nilai' => 'required|string|max:255',
            'kategori_ukuran' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0',
            'waktu_pakai_per_hari' => 'required|integer|min:0',
            'estimasi_waktu_barang' => 'required|integer|min:0',
            'pic' => 'required|string|max:255',
            'jabatan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'atasan' => 'required|string|max:255',
            'jabatan_atasan' => 'required|in:Chief Executive Officer (CEO),General Manager (GM),Head of Store,Admin Master,HR,Koordinator,Karyawan',
            'kondisi' => 'required|string|in:baik,perlu_servis,rusak',
        ]);

        $masaBarang = max($data['estimasi_waktu_barang'], 1);
        $data['pengurangan_harga_per_hari'] = $data['nilai'] / $masaBarang;
        $hariTerpakai = max(abs(now()->diffInDays(Carbon::parse($data['tanggal_pembelian']))), 0);
        $data['harga_per_hari_ini'] = max($data['nilai'] - ($data['pengurangan_harga_per_hari'] * $hariTerpakai), 0);

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

    public function scan(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $code = $request->input('code');

        $item = PeralatanKantor::where('barcode', $code)
            ->orWhere('kode_aset', $code)
            ->first();

        if (! $item) {
            return response()->json(['message' => 'Data aset tidak ditemukan.'], 404);
        }

        $masaBarang = max($item->estimasi_waktu_barang ?: 360, 1);
        $penyusutanPerHari = $item->nilai / $masaBarang;
        $hariTerpakai = $item->tanggal_pembelian ? max(abs(now()->diffInDays($item->tanggal_pembelian)), 0) : 0;
        $nilaiSekarang = max($item->nilai - ($penyusutanPerHari * $hariTerpakai), 0);

        return response()->json([
            'id' => $item->id,
            'kode_aset' => $item->kode_aset,
            'barcode' => $item->barcode,
            'nama_barang' => $item->nama_barang,
            'jumlah' => $item->jumlah,
            'detail' => $item->detail,
            'sub_kategori' => $item->sub_kategori,
            'keterangan' => $item->keterangan,
            'lokasi_unit' => $item->lokasi_unit,
            'ruangan' => $item->ruangan,
            'milik' => $item->milik,
            'pengadaan_tahun' => $item->pengadaan_tahun,
            'tanggal_pembelian' => $item->tanggal_pembelian?->format('Y-m-d'),
            'kategori_nilai' => $item->kategori_nilai,
            'kategori_ukuran' => $item->kategori_ukuran,
            'nilai' => (int) $item->nilai,
            'waktu_pakai_per_hari' => $item->waktu_pakai_per_hari,
            'estimasi_waktu_barang' => $item->estimasi_waktu_barang,
            'pengurangan_harga_per_hari' => round($penyusutanPerHari, 2),
            'harga_per_hari_ini' => round($nilaiSekarang, 0),
            'hari_terpakai' => $hariTerpakai,
            'penyusutan_per_hari' => round($penyusutanPerHari, 2),
            'nilai_sekarang' => round($nilaiSekarang, 0),
            'pic' => $item->pic,
            'jabatan' => $item->jabatan,
            'atasan' => $item->atasan,
            'jabatan_atasan' => $item->jabatan_atasan,
            'kondisi' => $item->kondisi,
        ]);
    }

    public function downloadTemplate()
    {
        return Excel::download(
            new PeralatanKantorTemplateExport,
            'Template_Import_Peralatan_Kantor.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        $import = new PeralatanKantorImport;
        Excel::import($import, $request->file('file'));

        $successCount = $import->getSuccessCount();
        $failures = $import->failures();

        $totalErrors = count($failures);
        $errorMessages = [];

        foreach ($failures as $failure) {
            $row = $failure->row();
            $errors = $failure->errors();
            $values = $failure->values();
            $nama = $values['Nama Barang'] ?? '-';
            $errorMessages[] = "Baris {$row} ({$nama}): ".implode(', ', $errors);
        }

        if ($totalErrors > 0) {
            $message = "Berhasil import {$successCount} data.";
            $message .= " {$totalErrors} baris gagal.";
            session()->flash('import_errors', $errorMessages);
            session()->flash('import_success_count', $successCount);
            session()->flash('import_error_count', $totalErrors);

            return redirect()->route('admin.peralatan-kantor.index')
                ->with('warning', $message);
        }

        return redirect()->route('admin.peralatan-kantor.index')
            ->with('success', "Berhasil import {$successCount} data peralatan kantor.");
    }
}
