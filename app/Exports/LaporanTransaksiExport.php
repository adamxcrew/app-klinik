<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanTransaksiExport implements FromView, ShouldAutoSize, WithEvents
{
    public $tanggal;
    public $shift_id;

    public function __construct($tanggal, $shift_id)
    {
        $this->tanggal = $tanggal;
        $this->shift_id = $shift_id;
    }

    public function view(): View
    {
        if ($this->shift_id == 1) {
            $awal = $this->tanggal . " 00:00:00";
            $akhir = $this->tanggal . " 12:00:00";
        } else {
            $awal = $this->tanggal . " 12:00:01";
            $akhir = $this->tanggal . " 23:59:59";
        }

        $laporan_transaksi = Pendaftaran::with('pasien', 'perusahaanAsuransi')
            ->whereBetween('created_at', [$awal, $akhir])
            ->where('status_pembayaran', 1)
            ->get();
        $data['laporan_transaksi'] = $laporan_transaksi;
        $data['jumlah_pendaftaran'] = Pendaftaran::count();

        return view('laporan-transaksi.laporan-transaksi-excel', $data);
    }

    public function registerEvents(): array
    {
        $jmlData = Pendaftaran::count() + 1;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:H1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:H' . $jmlData)->applyFromArray([
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
