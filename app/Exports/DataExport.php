<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithCustomStartCell, WithEvents
{
    protected Collection $data;
    protected array $headings;
    protected string $title;
    protected string $sheetTitle;

    public function __construct(Collection $data, array $headings, string $title, string $sheetTitle = 'Data')
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->title = $title;
        $this->sheetTitle = $sheetTitle;
    }

    public function collection(): Collection
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function title(): string
    {
        return $this->sheetTitle;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '3')->getFont()->setBold(true);
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('6C5CFF');
        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '3')->getFont()->getColor()->setRGB('FFFFFF');

        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn();
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
                $sheet->setCellValue('A1', 'Johen Office Management System');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:' . $sheet->getHighestColumn() . '2');
                $sheet->setCellValue('A2', $this->title);
                $sheet->getStyle('A2')->getFont()->setSize(11)->setItalic(true);
                $sheet->getStyle('A2')->getFont()->getColor()->setRGB('666666');
                $sheet->getStyle('A2')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
