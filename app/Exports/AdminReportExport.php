<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminReportExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize,
    WithCustomStartCell,
    WithEvents
{
    protected $totalAdmin;
    protected $totalPria;
    protected $totalWanita;
    protected $belumSet;

    public function __construct()
    {
        $admins = User::admins()->latest()->get();
        $this->totalAdmin = $admins->count();
        $this->totalPria = $admins->where('jenis_kelamin', 'L')->count();
        $this->totalWanita = $admins->where('jenis_kelamin', 'P')->count();
        $this->belumSet = $admins->whereNull('jenis_kelamin')->count();
    }

    public function collection()
    {
        return User::admins()->latest()->get()->map(function ($admin, $index) {
            $jk = '';
            if ($admin->jenis_kelamin == 'L') {
                $jk = 'Laki-laki';
            } elseif ($admin->jenis_kelamin == 'P') {
                $jk = 'Perempuan';
            } else {
                $jk = '-';
            }

            return [
                'no' => $index + 1,
                'kode_admin' => $admin->kode_admin ?? '-',
                'nama' => $admin->name,
                'jenis_kelamin' => $jk,
                'tahun' => $admin->created_at ? $admin->created_at->format('Y') : '-',
                'email' => $admin->email,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Admin',
            'Nama Admin',
            'Jenis Kelamin',
            'Tahun',
            'Email',
        ];
    }

    public function startCell(): string
    {
        return 'A7';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            7 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'LAPORAN DATA ADMIN');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'White House Premiere');
                $sheet->getStyle('A2')->getFont()->setSize(12);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A3', 'Tanggal Export: ' . now()->format('d/m/Y H:i'));
                $sheet->getStyle('A3')->getFont()->setSize(10)->setItalic(true);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A5:B5');
                $sheet->setCellValue('A5', 'Ringkasan');
                $sheet->getStyle('A5')->getFont()->setBold(true)->setSize(11);

                $sheet->setCellValue('A6', 'Total Admin:');
                $sheet->setCellValue('B6', $this->totalAdmin);
                $sheet->setCellValue('C6', 'Laki-laki:');
                $sheet->setCellValue('D6', $this->totalPria);
                $sheet->setCellValue('E6', 'Perempuan:');
                $sheet->setCellValue('F6', $this->totalWanita);

                $sheet->getStyle('A6:F6')->getFont()->setSize(10);

                $headerRange = 'A7:F7';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $lastRow = $sheet->getHighestRow();
                $dataRange = 'A8:F' . $lastRow;

                $sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => 'CCCCCC'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                $sheet->getStyle('A8:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('B8:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D8:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E8:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                for ($row = 8; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->setStartColor(new Color('F3F4F6'));
                    }
                }
            },
        ];
    }
}
