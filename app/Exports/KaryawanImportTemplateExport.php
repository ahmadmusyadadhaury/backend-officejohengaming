<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KaryawanImportTemplateExport implements FromArray, WithColumnWidths, WithEvents, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        $teams = Team::where('is_active', true)->orderBy('name')->pluck('name')->first();

        return [
            ['karyawan1', 'Nama Karyawan Contoh', '1234567890', $teams ?? '', 'Karyawan', 'password'],
        ];
    }

    public function headings(): array
    {
        return [
            'Username',
            'Nama',
            'NIK',
            'Tim',
            'Role',
            'Password',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => [$this, 'afterSheet'],
        ];
    }

    public function afterSheet(AfterSheet $event)
    {
        $sheet = $event->sheet->getDelegate();
        $teams = Team::where('is_active', true)
            ->orderBy('name')
            ->pluck('name')
            ->unique()
            ->values()
            ->map(fn ($name) => [$name])
            ->all();

        // Sheet tersembunyi sebagai sumber daftar tim untuk dropdown
        $spreadsheet = $sheet->getParent();
        $teamSheet = new Worksheet($spreadsheet, 'DaftarTim');
        $spreadsheet->addSheet($teamSheet);
        $teamSheet->setCellValue('A1', 'Nama Tim');
        $teamSheet->fromArray($teams, null, 'A2');
        $teamSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

        $lastTeamRow = count($teams) + 1;
        $validation = $sheet->getDataValidation('D2:D1000');
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setFormula1('=DaftarTim!$A$2:$A$'.$lastTeamRow);
        $validation->setShowDropDown(true);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setPromptTitle('Pilih Tim');
        $validation->setPrompt('Pilih tim dari daftar yang tersedia.');
        $validation->setShowErrorMessage(true);
        $validation->setErrorTitle('Tim tidak valid');
        $validation->setError('Pilih tim dari daftar yang tersedia.');

        $roleValidation = $sheet->getDataValidation('E2:E1000');
        $roleValidation->setType(DataValidation::TYPE_LIST);
        $roleValidation->setFormula1('"Karyawan,Koordinator,Admin"');
        $roleValidation->setShowDropDown(true);
        $roleValidation->setAllowBlank(true);
        $roleValidation->setShowInputMessage(true);
        $roleValidation->setPromptTitle('Pilih Role');
        $roleValidation->setPrompt('Karyawan, Koordinator, atau Admin.');
        $roleValidation->setShowErrorMessage(true);
        $roleValidation->setErrorTitle('Role tidak valid');
        $roleValidation->setError('Pilih Karyawan, Koordinator, atau Admin.');

        $sheet->getStyle('A2:F2')->getFont()->setItalic(true);
    }

    public function styles(Worksheet $sheet): array
    {
        $lastCol = 'F';
        $lastRow = $sheet->getHighestRow();

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

        $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ]);

        return [];
    }

    public function title(): string
    {
        return 'Template';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 22,
            'B' => 35,
            'C' => 24,
            'D' => 24,
            'E' => 16,
            'F' => 22,
        ];
    }
}
