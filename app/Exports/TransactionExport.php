<?php

namespace App\Exports;

use App\Models\Transaction;
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
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransactionExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    ShouldAutoSize,
    WithCustomStartCell,
    WithEvents
{
    protected $tab;

    public function __construct($tab = 'all')
    {
        $this->tab = $tab;
    }

    public function collection()
    {
        $query = Transaction::with(['user', 'property'])->orderBy('created_at', 'desc');

        if ($this->tab !== 'all') {
            $query->where('payment_type', $this->tab);
        }

        return $query->get()->map(function ($trx) {
            $paymentTypeLabel = [
                'booking' => 'Booking Fee',
                'dp' => 'DP (20%)',
                'cash' => 'Full Cash',
            ];

            $statusLabel = [
                'pending' => 'Pending',
                'success' => 'Sukses',
                'failed' => 'Gagal',
                'expired' => 'Kadaluarsa',
            ];

            return [
                'transaction_code' => $trx->transaction_code,
                'customer' => $trx->user->name ?? '-',
                'email' => $trx->user->email ?? '-',
                'property' => $trx->property->name ?? '-',
                'payment_type' => $paymentTypeLabel[$trx->payment_type] ?? $trx->payment_type,
                'payment_status' => $statusLabel[$trx->payment_status] ?? $trx->payment_status,
                'property_price' => $trx->property_price,
                'amount_paid' => $trx->amount_paid,
                'admin_fee' => $trx->admin_fee,
                'tax_amount' => $trx->tax_amount,
                'total_payable' => $trx->total_payable,
                'installment_plan' => $trx->is_installment ? ucfirst(str_replace('_', ' ', $trx->installment_plan)) : 'Tunai',
                'created_at' => $trx->created_at ? $trx->created_at->format('d/m/Y H:i') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Pelanggan',
            'Email',
            'Unit Properti',
            'Tipe Pembayaran',
            'Status',
            'Harga Properti',
            'Jumlah Dibayar',
            'Biaya Admin',
            'Pajak',
            'Total Tagihan',
            'Cicilan',
            'Tanggal Transaksi',
        ];
    }

    public function startCell(): string
    {
        return 'A9';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            9 => [
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

                $tabLabel = [
                    'all' => 'Semua Transaksi',
                    'booking' => 'Booking Fee',
                    'dp' => 'DP (20%)',
                    'cash' => 'Full Cash',
                ];

                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:M2');
                $sheet->setCellValue('A2', 'White House Premiere');
                $sheet->getStyle('A2')->getFont()->setSize(12);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:M3');
                $sheet->setCellValue('A3', 'Filter: ' . ($tabLabel[$this->tab] ?? 'Semua'));
                $sheet->getStyle('A3')->getFont()->setSize(10)->setItalic(true);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:M4');
                $sheet->setCellValue('A4', 'Tanggal Export: ' . now()->format('d/m/Y H:i'));
                $sheet->getStyle('A4')->getFont()->setSize(10)->setItalic(true);
                $sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $transactions = Transaction::with(['user', 'property'])->orderBy('created_at', 'desc');
                if ($this->tab !== 'all') {
                    $transactions->where('payment_type', $this->tab);
                }
                $allTrx = $transactions->get();

                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('A6', 'Ringkasan');
                $sheet->getStyle('A6')->getFont()->setBold(true)->setSize(11);

                $sheet->setCellValue('A7', 'Total Transaksi:');
                $sheet->setCellValue('B7', $allTrx->count());
                $sheet->setCellValue('C7', 'Total Pendapatan:');
                $sheet->setCellValue('D7', $allTrx->where('payment_status', 'success')->sum('total_payable'));

                $sheet->getStyle('A7:D7')->getFont()->setSize(10);

                $headerRange = 'A9:M9';
                $sheet->getStyle($headerRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);

                $lastRow = $sheet->getHighestRow();
                $dataRange = 'A10:M' . $lastRow;

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

                $sheet->getStyle('A10:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E10:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F10:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('L10:L' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('M10:M' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $columnLetters = ['G', 'H', 'I', 'J', 'K'];
                foreach ($columnLetters as $col) {
                    $sheet->getStyle($col . '10:' . $col . $lastRow)
                        ->getNumberFormat()->setFormatCode('#,##0');
                }

                for ($row = 10; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle('A' . $row . ':M' . $row)->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->setStartColor(['rgb' => 'F3F4F6']);
                    }
                }
            },
        ];
    }
}
