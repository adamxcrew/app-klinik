<?php

namespace App\Exports;

use App\Models\PendaftaranTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanTagihanExport implements FromView, ShouldAutoSize, WithEvents
{
    public $periode;
    public $perusahaan;

    public function __construct($periode, $perusahaan = null)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $laporanTagihan = PendaftaranTindakan::with(['pendaftaran', 'tindakan'])
            ->whereRaw("left(created_at,7)='" . $this->periode . "'");

        if ($this->perusahaan != null) {
            $jenis_layanan = $this->nama_perusahaan;
            $laporanTagihan->whereHas('pendaftaran', function ($query) use ($jenis_layanan) {
                return $query->where('pendaftaran.jenis_layanan', '=', $jenis_layanan);
            });
        }
        $laporanTagihan = $laporanTagihan->get();

        return view('laporan-tagihan.laporan-tagihan-perusahaan-excel', compact('laporanTagihan'));
    }

    public function registerEvents(): array
    {
        $jmlData = PendaftaranTindakan::count() + 1;
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
