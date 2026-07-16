<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeralatanKantorTemplateExport implements FromCollection, WithColumnWidths, WithHeadings, WithStyles, WithTitle
{
    public function collection(): Collection
    {
        return collect([
            [
                'Penanda Buku', '1',
                'Merah, orange, pink, kuning, hijau, neon, cyan, biru dan ungu', 'Bagus',
                'Lantai 1', 'Resepsionis', '2026', '2026-01-01',
                'Kecil', 'Kecil', 'ATK (Alat Tulis Kantor)', 'Perusahaan',
                '15000', '8', '720',
                '18.75', '14981.25',
                'Yuliana Sventy Yasmine Aulhia Sugiat', 'Human Resources Generalist',
                'Gonzaga Gogo Silalahi', 'GM',
                'JSAAtk9', 'JSAAtk9',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jumlah',
            'Detail',
            'Keterangan',
            'Lokasi Unit',
            'Ruangan',
            'Pengadaan (in tahun)',
            'Tanggal Pembelian',
            'Kategori Nilai',
            'Kategori Ukuran',
            'Sub-Kategori',
            'Milik',
            'Nilai (in Rupiah)',
            'Waktu Pakai Barang Perhari Ini',
            'Estimasi Waktu Barang',
            'Pengurangan Harga Aset Perhari',
            'Harga Barang Perhari Ini',
            'PIC',
            'Jabatan PIC',
            'Atasan',
            'Jabatan Atasan',
            'Kode Asset',
            'Barcode',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $lastCol = 'W';

        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '6C5CFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle("A2:{$lastCol}2")->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F3F0FF'],
            ],
        ]);

        $sheet->getStyle("A1:{$lastCol}2")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22,
            'B' => 10,
            'C' => 35,
            'D' => 20,
            'E' => 16,
            'F' => 16,
            'G' => 20,
            'H' => 20,
            'I' => 16,
            'J' => 16,
            'K' => 28,
            'L' => 16,
            'M' => 16,
            'N' => 28,
            'O' => 22,
            'P' => 28,
            'Q' => 26,
            'R' => 35,
            'S' => 28,
            'T' => 28,
            'U' => 22,
            'V' => 16,
            'W' => 16,
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}
