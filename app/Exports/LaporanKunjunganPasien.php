<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use DB;

class LaporanKunjunganPasien implements FromView, ShouldAutoSize, WithEvents, WithTitle
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
        $pendaftaran = Pendaftaran::with('pasien', 'perusahaanAsuransi', 'poliklinik')
            ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$this->tanggal_awal, $this->tanggal_akhir])
            ->orderBy('created_at')
            ->get();

        return view('laporan.kunjungan-pasien-excel', ['laporan' => $pendaftaran]);
    }

    public function title(): string
    {
        return 'Laporan Kunjungan Pasien';
    }

    public function registerEvents(): array
    {
        $jmlData = Pendaftaran::with('pasien', 'perusahaanAsuransi', 'poliklinik')
        ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$this->tanggal_awal, $this->tanggal_akhir])
        ->count() + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:G1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:E' . $jmlData)->applyFromArray([
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
