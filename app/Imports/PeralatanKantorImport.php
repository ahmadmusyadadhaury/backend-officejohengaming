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
        if (empty($row['Nama Barang']) && empty($row['Jumlah']) && empty($row['Sub Kategori'])) {
            return null;
        }

        $this->successCount++;

        $masaBarang = max((int) ($row['Estimasi Waktu Barang'] ?? 360), 1);
        $nilai = (float) ($row['Nilai'] ?? 0);
        $penguranganPerHari = $nilai / $masaBarang;

        $tanggalPembelian = ! empty($row['Tanggal Pembelian']) ? $row['Tanggal Pembelian'] : null;
        $hariTerpakai = $tanggalPembelian ? max(abs(now()->diffInDays(Carbon::parse($tanggalPembelian))), 0) : 0;
        $hargaPerHariIni = max($nilai - ($penguranganPerHari * $hariTerpakai), 0);

        return new PeralatanKantor([
            'nama_barang' => $row['Nama Barang'] ?? '',
            'jumlah' => (int) ($row['Jumlah'] ?? 1),
            'detail' => $row['Detail'] ?? null,
            'sub_kategori' => $row['Sub Kategori'] ?? '',
            'keterangan' => $row['Keterangan'] ?? null,
            'lokasi_unit' => $row['Lokasi Unit'] ?? '',
            'ruangan' => $row['Ruangan'] ?? '',
            'milik' => $row['Milik'] ?? '',
            'pengadaan_tahun' => (int) ($row['Pengadaan Tahun'] ?? now()->year),
            'tanggal_pembelian' => $tanggalPembelian,
            'kategori_nilai' => $row['Kategori Nilai'] ?? '',
            'kategori_ukuran' => $row['Kategori Ukuran'] ?? '',
            'nilai' => $nilai,
            'waktu_pakai_per_hari' => (int) ($row['Waktu Pakai Per Hari'] ?? 0),
            'estimasi_waktu_barang' => (int) ($row['Estimasi Waktu Barang'] ?? 360),
            'pengurangan_harga_per_hari' => $penguranganPerHari,
            'harga_per_hari_ini' => $hargaPerHariIni,
            'pic' => $row['PIC'] ?? '',
            'jabatan' => $row['Jabatan'] ?? '',
            'atasan' => $row['Atasan'] ?? '',
            'jabatan_atasan' => $row['Jabatan Atasan'] ?? '',
            'kondisi' => $row['Kondisi'] ?? 'baik',
        ]);
    }

    public function rules(): array
    {
        $maxYear = now()->year + 1;

        return [
            'Nama Barang' => 'required|string|max:255',
            'Jumlah' => 'required|integer|min:1',
            'Sub Kategori' => 'required|string|max:255',
            'Lokasi Unit' => 'required|string|max:255',
            'Ruangan' => 'required|string|max:255',
            'Milik' => 'required|string|max:255',
            'Pengadaan Tahun' => 'required|integer|min:1900|max:'.$maxYear,
            'Tanggal Pembelian' => 'required',
            'Kategori Nilai' => 'required|string|max:255',
            'Kategori Ukuran' => 'required|string|max:255',
            'Nilai' => 'required|numeric|min:0',
            'Waktu Pakai Per Hari' => 'required|integer|min:0',
            'Estimasi Waktu Barang' => 'required|integer|min:0',
            'PIC' => 'required|string|max:255',
            'Jabatan' => 'required|string|max:255',
            'Atasan' => 'required|string|max:255',
            'Jabatan Atasan' => 'required|string|max:255',
            'Kondisi' => 'required|string|in:baik,perlu_servis,rusak',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'Nama Barang.required' => 'Nama Barang wajib diisi',
            'Jumlah.required' => 'Jumlah wajib diisi',
            'Sub Kategori.required' => 'Sub Kategori wajib diisi',
            'Lokasi Unit.required' => 'Lokasi Unit wajib diisi',
            'Ruangan.required' => 'Ruangan wajib diisi',
            'Milik.required' => 'Milik wajib diisi',
            'Pengadaan Tahun.required' => 'Pengadaan Tahun wajib diisi',
            'Tanggal Pembelian.required' => 'Tanggal Pembelian wajib diisi',
            'Kategori Nilai.required' => 'Kategori Nilai wajib diisi',
            'Kategori Ukuran.required' => 'Kategori Ukuran wajib diisi',
            'Nilai.required' => 'Nilai wajib diisi',
            'Nilai.numeric' => 'Nilai harus berupa angka',
            'Waktu Pakai Per Hari.required' => 'Waktu Pakai Per Hari wajib diisi',
            'Estimasi Waktu Barang.required' => 'Estimasi Waktu Barang wajib diisi',
            'PIC.required' => 'PIC wajib diisi',
            'Jabatan.required' => 'Jabatan wajib diisi',
            'Atasan.required' => 'Atasan wajib diisi',
            'Jabatan Atasan.required' => 'Jabatan Atasan wajib diisi',
            'Kondisi.required' => 'Kondisi wajib diisi',
            'Kondisi.in' => 'Kondisi harus salah satu: baik, perlu_servis, atau rusak',
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
