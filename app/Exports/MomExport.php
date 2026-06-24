<?php

namespace App\Exports;

use App\Models\Mom;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class MomExport implements FromCollection, WithEvents, WithTitle
{
    protected Mom $mom;

    public function __construct(Mom $mom)
    {
        $this->mom = $mom;
    }

    public function collection()
    {
        return collect([]);
    }

    public function title(): string
    {
        return 'Meeting MOM';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $meeting = $this->mom->meeting;
                $room = $meeting->room?->name ?? '-';
                $date = $meeting->meeting_date->format('d/m/Y');
                $start = \Carbon\Carbon::parse($meeting->start_time)->format('H:i');
                $end = \Carbon\Carbon::parse($meeting->end_time)->format('H:i');
                $duration = $start.' - '.$end;

                $participants = $meeting->participants->pluck('name')->implode(', ');
                $requester = $meeting->requester?->name ?? '-';
                $audience = $requester;
                if ($participants) {
                    $audience .= ', '.$participants;
                }

                $colEnd = 'D';
                $styleHeader = [
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '6C5CFF']],
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => ['borderStyle' => 'thin'],
                    ],
                ];

                $styleTitle = [
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ];

                $styleSubtitle = [
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => ['horizontal' => 'left'],
                ];

                $styleInfo = [
                    'font' => ['size' => 11],
                    'alignment' => ['horizontal' => 'left'],
                ];

                $styleTableHeader = [
                    'font' => ['bold' => true, 'size' => 11],
                    'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']],
                    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => 'center'],
                    'borders' => [
                        'allBorders' => ['borderStyle' => 'thin'],
                    ],
                ];

                $styleTableCell = [
                    'borders' => [
                        'allBorders' => ['borderStyle' => 'thin'],
                    ],
                    'alignment' => ['vertical' => 'top', 'wrapText' => true],
                ];

                // Row 1: Main Title
                $sheet->mergeCells("A1:{$colEnd}1");
                $sheet->setCellValue('A1', 'MINUTES OF MEETING');
                $sheet->getStyle('A1')->applyFromArray($styleTitle);

                // Row 3-6: Info Section
                $row = 3;
                $sheet->setCellValue("A{$row}", 'AUDIENCE');
                $sheet->setCellValue("B{$row}", $audience);
                $sheet->getStyle("A{$row}")->applyFromArray(['font' => ['bold' => true, 'size' => 11]]);
                $sheet->getStyle("B{$row}")->applyFromArray($styleInfo);
                $sheet->mergeCells("B{$row}:{$colEnd}{$row}");

                $row++;
                $sheet->setCellValue("A{$row}", 'HARI/TANGGAL');
                $sheet->setCellValue("B{$row}", $date);
                $sheet->getStyle("A{$row}")->applyFromArray(['font' => ['bold' => true, 'size' => 11]]);
                $sheet->getStyle("B{$row}")->applyFromArray($styleInfo);
                $sheet->mergeCells("B{$row}:{$colEnd}{$row}");

                $row++;
                $sheet->setCellValue("A{$row}", 'DURASI');
                $sheet->setCellValue("B{$row}", $duration);
                $sheet->getStyle("A{$row}")->applyFromArray(['font' => ['bold' => true, 'size' => 11]]);
                $sheet->getStyle("B{$row}")->applyFromArray($styleInfo);
                $sheet->mergeCells("B{$row}:{$colEnd}{$row}");

                $row++;
                $sheet->setCellValue("A{$row}", 'TEMPAT');
                $sheet->setCellValue("B{$row}", $room);
                $sheet->getStyle("A{$row}")->applyFromArray(['font' => ['bold' => true, 'size' => 11]]);
                $sheet->getStyle("B{$row}")->applyFromArray($styleInfo);
                $sheet->mergeCells("B{$row}:{$colEnd}{$row}");

                // Row 8: Table 1 - Point Of Discuss & Speaker 1
                $row = 8;
                $sheet->setCellValue("A{$row}", 'Point Of Discuss');
                $sheet->setCellValue("B{$row}", 'Speaker 1');
                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($styleTableHeader);

                $row++;
                $sheet->setCellValue("A{$row}", $meeting->what ?? '-');
                $sheet->setCellValue("B{$row}", $requester);
                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($styleTableCell);
                $sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
                $sheet->getStyle("B{$row}")->getAlignment()->setWrapText(true);

                // Row 11: Table 2 - Minutes of Meeting
                $row = 11;
                $sheet->mergeCells("A{$row}:B{$row}");
                $sheet->setCellValue("A{$row}", 'Minutes of Meeting');
                $sheet->getStyle("A{$row}")->applyFromArray($styleSubtitle);

                $row++;
                $sheet->setCellValue("A{$row}", 'Point Of Discuss');
                $sheet->setCellValue("B{$row}", 'Notes');
                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($styleTableHeader);

                $row++;
                $sheet->setCellValue("A{$row}", $meeting->why ?? '-');
                $sheet->setCellValue("B{$row}", $this->mom->decisions ?? '-');
                $sheet->getStyle("A{$row}:B{$row}")->applyFromArray($styleTableCell);
                $sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
                $sheet->getStyle("B{$row}")->getAlignment()->setWrapText(true);

                // Row 15: Table 3 - Meeting Summary
                $row = 15;
                $sheet->mergeCells("A{$row}:D{$row}");
                $sheet->setCellValue("A{$row}", 'MEETING SUMMARY');
                $sheet->getStyle("A{$row}")->applyFromArray($styleSubtitle);

                $row++;
                $sheet->setCellValue("A{$row}", 'SUMMARY');
                $sheet->setCellValue("B{$row}", 'Notes');
                $sheet->setCellValue("C{$row}", 'Responsibility');
                $sheet->setCellValue("D{$row}", 'Speaker 2');
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($styleTableHeader);

                $row++;
                $sheet->setCellValue("A{$row}", $this->mom->summary ?? '-');
                $sheet->setCellValue("B{$row}", $this->mom->action_plan ?? '-');
                $sheet->setCellValue("C{$row}", $this->mom->pic ?? '-');
                $sheet->setCellValue("D{$row}", $requester);
                $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($styleTableCell);
                $sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
                $sheet->getStyle("B{$row}")->getAlignment()->setWrapText(true);
                $sheet->getStyle("C{$row}")->getAlignment()->setWrapText(true);
                $sheet->getStyle("D{$row}")->getAlignment()->setWrapText(true);

                // Auto-size columns
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);

                $sheet->setShowGridlines(false);

                // Set minimum width
                foreach (['A', 'B', 'C', 'D'] as $col) {
                    if ($sheet->getColumnDimension($col)->getWidth() < 20) {
                        $sheet->getColumnDimension($col)->setWidth(20);
                    }
                }
            },
        ];
    }
}
