<?php

namespace App\Exports;

use App\Models\PendaftaranFeeTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanFeeTindakanExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        $fee = PendaftaranFeeTindakan::with(['tindakan', 'pendaftaran', 'user'])->get();
        return view('laporan-fee-tindakan.laporan-fee-tindakan-excel', ['fees' => $fee]);
    }

    public function registerEvents(): array
    {
        $jmlData = PendaftaranFeeTindakan::count() + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:I' . $jmlData)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
