<?php

namespace App\Imports;

use App\Models\PeralatanKantor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;

HeadingRowFormatter::default('none');

class PeralatanKantorImport implements SkipsOnFailure, ToModel, WithBatchInserts, WithCalculatedFormulas, WithHeadingRow
{
    use SkipsFailures;

    private int $successCount = 0;

    private array $errors = [];

    private array $usedKodeAset = [];

    private array $usedBarcode = [];

    private static array $debugKeys = [];

    private static int $debugCount = 0;

    public function model(array $row)
    {
        if (self::$debugCount < 3) {
            self::$debugKeys[] = $row;
            self::$debugCount++;
            if (self::$debugCount === 3) {
                Log::info('IMPORT DEBUG KEYS:', array_map(fn ($r) => array_keys($r), self::$debugKeys));
                Log::info('IMPORT DEBUG ROW 1:', self::$debugKeys[0]);
                file_put_contents(storage_path('logs/import_debug.json'), json_encode(array_map(fn ($r) => array_keys($r), self::$debugKeys), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }

        if (empty($row['Nama Barang']) && empty($row['Jumlah']) && empty($row['Sub-Kategori'])) {
            return null;
        }

        $row = $this->cleanRow($row);
        $errors = $this->validateRow($row);

        if (! empty($errors)) {
            foreach ($errors as $error) {
                $this->errors[] = $error;
            }

            return null;
        }

        if (! empty($row['Kode Asset'])) {
            $this->usedKodeAset[] = $row['Kode Asset'];
        }
        if (! empty($row['Barcode'])) {
            $this->usedBarcode[] = $row['Barcode'];
        }

        $this->successCount++;

        $nilai = (float) $row['Nilai (in Rupiah)'];
        $masaBarang = max((int) $row['Estimasi Waktu Barang'], 1);
        $penguranganPerHari = $nilai / $masaBarang;

        $tanggalPembelian = $row['Tanggal Pembelian'];
        $hariTerpakai = 0;
        if ($tanggalPembelian) {
            try {
                $hariTerpakai = max(abs(now()->diffInDays(Carbon::parse($tanggalPembelian))), 0);
            } catch (\Exception $e) {
                $hariTerpakai = 0;
            }
        }
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
            'nama_barang' => $row['Nama Barang'],
            'jumlah' => (int) $row['Jumlah'],
            'detail' => $row['Detail'] ?? null,
            'keterangan' => $row['Keterangan'] ?? null,
            'lokasi_unit' => $row['Lokasi Unit'],
            'ruangan' => $row['Ruangan'],
            'pengadaan_tahun' => (int) $row['Pengadaan (in tahun)'],
            'tanggal_pembelian' => $tanggalPembelian,
            'kategori_nilai' => $row['Kategori Nilai'],
            'kategori_ukuran' => $row['Kategori Ukuran'],
            'sub_kategori' => $row['Sub-Kategori'],
            'milik' => $row['Milik'],
            'nilai' => $nilai,
            'waktu_pakai_per_hari' => (int) ($row['Waktu Pakai Barang Perhari Ini'] ?? 0),
            'estimasi_waktu_barang' => (int) ($row['Estimasi Waktu Barang'] ?? 0),
            'pengurangan_harga_per_hari' => $penguranganPerHari,
            'harga_per_hari_ini' => $hargaPerHariIni,
            'pic' => $row['PIC'] ?? null,
            'jabatan' => $row['Jabatan PIC'] ?? null,
            'atasan' => $row['Atasan'] ?? null,
            'jabatan_atasan' => $row['Jabatan Atasan'] ?? null,
            'kondisi' => 'baik',
        ]);
    }

    private function cleanRow(array $row): array
    {
        foreach ($row as $key => $value) {
            if ($value instanceof \DateTime) {
                $row[$key] = $value->format('Y-m-d');
            } elseif (is_float($value) && floor($value) == $value && $value > 40000 && $value < 60000) {
                try {
                    $row[$key] = Date::excelToDateTimeObject($value)->format('Y-m-d');
                } catch (\Exception $e) {
                    $row[$key] = (string) $value;
                }
            } elseif (is_string($value)) {
                $row[$key] = trim($value);
            }
        }

        if (! empty($row['Tanggal Pembelian']) && is_string($row['Tanggal Pembelian'])) {
            $dateStr = $row['Tanggal Pembelian'];

            if (preg_match('/^=DATE\((\d+),(\d+),(\d+)\)$/i', $dateStr, $m)) {
                $row['Tanggal Pembelian'] = sprintf('%04d-%02d-%02d', $m[1], $m[2], $m[3]);
            } else {
                $formats = ['Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y', 'd-m-y', 'd/m/y'];
                $parsed = false;
                foreach ($formats as $fmt) {
                    try {
                        $d = Carbon::createFromFormat($fmt, $dateStr);
                        if ($d && $d->year > 1900) {
                            $row['Tanggal Pembelian'] = $d->format('Y-m-d');
                            $parsed = true;
                            break;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                if (! $parsed) {
                    try {
                        $row['Tanggal Pembelian'] = Carbon::parse($dateStr)->format('Y-m-d');
                    } catch (\Exception $e) {
                    }
                }
            }
        }

        if (! empty($row['Tanggal Pembelian']) && is_numeric($row['Tanggal Pembelian'])) {
            try {
                $row['Tanggal Pembelian'] = Date::excelToDateTimeObject((float) $row['Tanggal Pembelian'])->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        foreach (['Jumlah', 'Pengadaan (in tahun)', 'Waktu Pakai Barang Perhari Ini', 'Estimasi Waktu Barang'] as $field) {
            if (isset($row[$field])) {
                $row[$field] = (int) round((float) $row[$field]);
            }
        }

        if (isset($row['Nilai (in Rupiah)'])) {
            $nilai = $row['Nilai (in Rupiah)'];
            if (is_string($nilai)) {
                $nilai = str_replace(['Rp', 'rp', '.', ','], ['', '', '', '.'], $nilai);
                $nilai = preg_replace('/\.+$/', '', $nilai);
            }
            $row['Nilai (in Rupiah)'] = (float) $nilai;
        }

        if (isset($row['Kode Asset'])) {
            $val = (string) $row['Kode Asset'];
            $row['Kode Asset'] = str_starts_with($val, '=') ? null : $val;
        }
        if (isset($row['Barcode'])) {
            $val = (string) $row['Barcode'];
            $row['Barcode'] = str_starts_with($val, '=') ? null : $val;
        }
        if (isset($row['Keterangan'])) {
            $val = (string) $row['Keterangan'];
            $row['Keterangan'] = str_starts_with($val, '=') ? null : $val;
        }
        if (isset($row['Jabatan PIC'])) {
            $val = (string) $row['Jabatan PIC'];
            $row['Jabatan PIC'] = str_starts_with($val, '=') ? null : $val;
        }
        if (isset($row['Jabatan Atasan'])) {
            $val = (string) $row['Jabatan Atasan'];
            $row['Jabatan Atasan'] = str_starts_with($val, '=') ? null : $val;
        }

        return $row;
    }

    private function validateRow(array $row): array
    {
        $errors = [];
        $maxYear = now()->year + 1;

        if (empty($row['Nama Barang'])) {
            $errors[] = 'Nama Barang wajib diisi';
        }
        if (empty($row['Jumlah']) || $row['Jumlah'] < 1) {
            $errors[] = 'Jumlah wajib diisi minimal 1';
        }
        if (empty($row['Lokasi Unit'])) {
            $errors[] = 'Lokasi Unit wajib diisi';
        }
        if (empty($row['Ruangan'])) {
            $errors[] = 'Ruangan wajib diisi';
        }
        if (empty($row['Pengadaan (in tahun)']) || $row['Pengadaan (in tahun)'] < 1900 || $row['Pengadaan (in tahun)'] > $maxYear) {
            $errors[] = 'Pengadaan (in tahun) wajib diisi dengan tahun yang valid';
        }
        if (empty($row['Tanggal Pembelian'])) {
            $errors[] = 'Tanggal Pembelian wajib diisi';
        }
        if (empty($row['Kategori Nilai'])) {
            $errors[] = 'Kategori Nilai wajib diisi';
        }
        if (empty($row['Kategori Ukuran'])) {
            $errors[] = 'Kategori Ukuran wajib diisi';
        }
        if (empty($row['Sub-Kategori'])) {
            $errors[] = 'Sub-Kategori wajib diisi';
        }
        if (empty($row['Milik'])) {
            $errors[] = 'Milik wajib diisi';
        }
        if (! isset($row['Nilai (in Rupiah)']) || $row['Nilai (in Rupiah)'] < 0) {
            $errors[] = 'Nilai (in Rupiah) wajib diisi';
        }

        $kodeAset = $row['Kode Asset'] ?? null;
        if ($kodeAset && (PeralatanKantor::where('kode_aset', $kodeAset)->exists() || in_array($kodeAset, $this->usedKodeAset))) {
            $errors[] = "Kode Asset '$kodeAset' sudah digunakan oleh data lain";
        }

        $barcode = $row['Barcode'] ?? null;
        if ($barcode && (PeralatanKantor::where('barcode', $barcode)->exists() || in_array($barcode, $this->usedBarcode))) {
            $errors[] = "Barcode '$barcode' sudah digunakan oleh data lain";
        }

        return $errors;
    }

    public function getFailures(): array
    {
        return [];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
