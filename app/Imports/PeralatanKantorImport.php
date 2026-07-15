<?php

namespace App\Imports;

use App\Models\PeralatanKantor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class PeralatanKantorImport implements SkipsOnFailure, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{
    use SkipsFailures;

    private int $successCount = 0;

    private int $rowNumber = 1;

    public function model(array $row)
    {
        if (empty($row['Nama Barang']) && empty($row['Jumlah']) && empty($row['Sub-Kategori'])) {
            return null;
        }

        $this->successCount++;

        $masaBarang = max((int) ($row['Estimasi Waktu Barang'] ?? 360), 1);
        $nilai = (float) ($row['Nilai (Rp)'] ?? 0);
        $penguranganPerHari = $nilai / $masaBarang;

        $tanggalPembelian = ! empty($row['Tanggal Pembelian']) ? $row['Tanggal Pembelian'] : null;
        $hariTerpakai = $tanggalPembelian ? max(abs(now()->diffInDays(Carbon::parse($tanggalPembelian))), 0) : 0;
        $hargaPerHariIni = max($nilai - ($penguranganPerHari * $hariTerpakai), 0);

        $kodeAset = $row['Kode Asset'] ?? null;
        $barcode = $row['Barcode'] ?? null;

        if (empty($kodeAset)) {
            $kodeAset = PeralatanKantor::generateKodeAset();
        }
        if (empty($barcode)) {
            $barcode = $kodeAset;
        }

        return new PeralatanKantor([
            'kode_aset' => $kodeAset,
            'barcode' => $barcode,
            'nama_barang' => $row['Nama Barang'] ?? '',
            'jumlah' => (int) ($row['Jumlah'] ?? 1),
            'detail' => $row['Detail'] ?? null,
            'keterangan' => $row['Keterangan'] ?? null,
            'lokasi_unit' => $row['Lokasi Unit'] ?? '',
            'ruangan' => $row['Ruangan'] ?? '',
            'pengadaan_tahun' => (int) ($row['Pengadaan (in tahun)'] ?? now()->year),
            'tanggal_pembelian' => $tanggalPembelian,
            'kategori_nilai' => $row['Kategori Nilai'] ?? '',
            'kategori_ukuran' => $row['Kategori Ukuran'] ?? '',
            'sub_kategori' => $row['Sub-Kategori'] ?? '',
            'milik' => $row['Milik'] ?? '',
            'nilai' => $nilai,
            'waktu_pakai_per_hari' => (int) ($row['Waktu Pakai Barang Perhari Ini'] ?? 0),
            'estimasi_waktu_barang' => (int) ($row['Estimasi Waktu Barang'] ?? 360),
            'pengurangan_harga_per_hari' => $penguranganPerHari,
            'harga_per_hari_ini' => $hargaPerHariIni,
            'pic' => $row['PIC'] ?? '',
            'jabatan' => $row['Jabatan PIC'] ?? '',
            'atasan' => $row['Atasan'] ?? '',
            'jabatan_atasan' => $row['Jabatan Atasan'] ?? '',
            'kondisi' => 'baik',
        ]);
    }

    public function rules(): array
    {
        $maxYear = now()->year + 1;

        return [
            'Kode Asset' => 'nullable|string|max:255|unique:peralatan_kantor,kode_aset',
            'Barcode' => 'nullable|string|max:255|unique:peralatan_kantor,barcode',
            'Nama Barang' => 'required|string|max:255',
            'Jumlah' => 'required|integer|min:1',
            'Detail' => 'nullable|string',
            'Keterangan' => 'nullable|string',
            'Lokasi Unit' => 'required|string|max:255',
            'Ruangan' => 'required|string|max:255',
            'Pengadaan (in tahun)' => 'required|integer|min:1900|max:'.$maxYear,
            'Tanggal Pembelian' => 'required',
            'Kategori Nilai' => 'required|string|max:255',
            'Kategori Ukuran' => 'required|string|max:255',
            'Sub-Kategori' => 'required|string|max:255',
            'Milik' => 'required|string|max:255',
            'Nilai (Rp)' => 'required|numeric|min:0',
            'Waktu Pakai Barang Perhari Ini' => 'required|integer|min:0',
            'Estimasi Waktu Barang' => 'required|integer|min:0',
            'PIC' => 'required|string|max:255',
            'Jabatan PIC' => 'required|string|max:255',
            'Atasan' => 'required|string|max:255',
            'Jabatan Atasan' => 'required|string|max:255',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'Kode Asset.unique' => 'Kode Asset sudah digunakan oleh data lain',
            'Barcode.unique' => 'Barcode sudah digunakan oleh data lain',
            'Nama Barang.required' => 'Nama Barang wajib diisi',
            'Jumlah.required' => 'Jumlah wajib diisi',
            'Lokasi Unit.required' => 'Lokasi Unit wajib diisi',
            'Ruangan.required' => 'Ruangan wajib diisi',
            'Pengadaan (in tahun).required' => 'Pengadaan (in tahun) wajib diisi',
            'Tanggal Pembelian.required' => 'Tanggal Pembelian wajib diisi',
            'Kategori Nilai.required' => 'Kategori Nilai wajib diisi',
            'Kategori Ukuran.required' => 'Kategori Ukuran wajib diisi',
            'Sub-Kategori.required' => 'Sub-Kategori wajib diisi',
            'Milik.required' => 'Milik wajib diisi',
            'Nilai (Rp).required' => 'Nilai (Rp) wajib diisi',
            'Nilai (Rp).numeric' => 'Nilai (Rp) harus berupa angka',
            'Waktu Pakai Barang Perhari Ini.required' => 'Waktu Pakai Barang Perhari Ini wajib diisi',
            'Estimasi Waktu Barang.required' => 'Estimasi Waktu Barang wajib diisi',
            'PIC.required' => 'PIC wajib diisi',
            'Jabatan PIC.required' => 'Jabatan PIC wajib diisi',
            'Atasan.required' => 'Atasan wajib diisi',
            'Jabatan Atasan.required' => 'Jabatan Atasan wajib diisi',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
}
