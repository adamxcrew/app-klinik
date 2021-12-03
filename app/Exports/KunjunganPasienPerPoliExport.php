<?php

namespace App\Exports;

use App\Models\Poliklinik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KunjunganPasienPerPoliExport implements FromView, ShouldAutoSize, WithEvents
{
    public $tanggal_awal;
    public $tanggal_akhir;


    public function __construct($tanggal_awal, $tanggal_akhir)
    {
        $this->tanggal_awal = $tanggal_awal;
        $this->tanggal_akhir = $tanggal_akhir;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $kunjungan = Poliklinik::KunjunganPasienPerPoli($this->tanggal_awal, $this->tanggal_akhir)->get();
        return view('laporan.kunjungan-perpoli-excel', ['laporan' => $kunjungan]);
    }

    public function registerEvents(): array
    {
        $jmlData = Poliklinik::KunjunganPasienPerPoli()->count() + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:C' . $jmlData)->applyFromArray([
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
