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

class PeralatanKantorTemplateExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    public function collection(): Collection
    {
        return collect([
            [
                'Meja Kantor', '5', 'Meja kayu uk. 120x60cm', 'Furniture', 'Meja untuk staf',
                'Johen Office', 'Ruang Staf', 'Perusahaan', '2025', '2025-06-01',
                'Kurang dari 5 Juta', 'Sedang', '3500000', '8', '720',
                'Ahmad', 'Koordinator', 'Budi', 'General Manager (GM)', 'baik',
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jumlah',
            'Detail',
            'Sub Kategori',
            'Keterangan',
            'Lokasi Unit',
            'Ruangan',
            'Milik',
            'Pengadaan Tahun',
            'Tanggal Pembelian',
            'Kategori Nilai',
            'Kategori Ukuran',
            'Nilai',
            'Waktu Pakai Per Hari',
            'Estimasi Waktu Barang',
            'PIC',
            'Jabatan',
            'Atasan',
            'Jabatan Atasan',
            'Kondisi',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $lastCol = 'T';

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
            'C' => 30,
            'D' => 18,
            'E' => 22,
            'F' => 20,
            'G' => 18,
            'H' => 18,
            'I' => 18,
            'J' => 20,
            'K' => 22,
            'L' => 18,
            'M' => 16,
            'N' => 22,
            'O' => 24,
            'P' => 20,
            'Q' => 28,
            'R' => 20,
            'S' => 28,
            'T' => 14,
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}
