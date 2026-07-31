<?php

namespace App\Exports;

use App\Models\Ticket;
use App\Support\Ticket as TicketSupport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromCollection, WithCustomStartCell, WithEvents, WithHeadings, WithStyles, WithTitle
{
    use Exportable;

    public function __construct(
        protected $tickets,
        protected string $filterLabel = ''
    ) {}

    public function collection(): Collection
    {
        return $this->tickets->map(fn (Ticket $ticket) => [
            'ticket_number' => $ticket->ticket_number,
            'title' => $ticket->title,
            'category' => $ticket->category?->name ?? '-',
            'requester' => $ticket->requester?->name ?? '-',
            'department' => $ticket->department ?? '-',
            'location' => $ticket->location ?? '-',
            'priority' => TicketSupport::priorityLabel($ticket->priority),
            'status' => TicketSupport::statusLabel($ticket->status),
            'technician' => $ticket->technician?->name ?? '-',
            'created_at' => $ticket->created_at?->format('d/m/Y H:i'),
            'resolved_at' => $ticket->resolved_at?->format('d/m/Y H:i'),
            'closed_at' => $ticket->closed_at?->format('d/m/Y H:i'),
            'rating' => $ticket->rating?->rating ?? '-',
        ]);
    }

    public function headings(): array
    {
        return [
            'No. Ticket', 'Judul', 'Kategori', 'Pengaju', 'Departemen',
            'Lokasi', 'Prioritas', 'Status', 'Teknisi',
            'Dibuat', 'Diselesaikan', 'Ditutup', 'Rating',
        ];
    }

    public function title(): string
    {
        return 'Laporan Ticket';
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A3:'.$sheet->getHighestColumn().'3')->getFont()->setBold(true);
        $sheet->getStyle('A3:'.$sheet->getHighestColumn().'3')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('6C5CFF');
        $sheet->getStyle('A3:'.$sheet->getHighestColumn().'3')->getFont()->getColor()->setRGB('FFFFFF');

        $lastRow = $sheet->getHighestRow();
        $lastCol = $sheet->getHighestColumn();
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:'.$sheet->getHighestColumn().'1');
                $sheet->setCellValue('A1', 'Johen Office Management System');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:'.$sheet->getHighestColumn().'2');
                $sheet->setCellValue('A2', 'Laporan Ticket'.($this->filterLabel ? ' — '.$this->filterLabel : ''));
                $sheet->getStyle('A2')->getFont()->setSize(11)->setItalic(true);
                $sheet->getStyle('A2')->getFont()->getColor()->setRGB('666666');
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
