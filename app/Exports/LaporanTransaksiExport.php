<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class LaporanTransaksiExport implements FromView, ShouldAutoSize, WithEvents
{
    public $tanggal;
    public $nama_shift;

    public function __construct($tanggal, $nama_shift)
    {
        $this->tanggal = $tanggal;
        $this->nama_shift = $nama_shift;
    }

    public function view(): View
    {

        $shift = config('datareferensi.kasir_shift');
        $selectedShift = $shift[array_search($this->nama_shift, array_column($shift, 'nama_shift'))];
        $awal   = $this->tanggal . ' ' . $selectedShift['waktu_mulai'];
        $akhir  = $this->tanggal . ' ' . $selectedShift['waktu_selesai'];
        $laporan_transaksi = Pendaftaran::with('pasien', 'perusahaanAsuransi', 'userKasir')
            ->whereBetween(\DB::raw('left(created_at,16)'), [$awal, $akhir])
            ->where('status_pembayaran', 1)
            ->get();
        $data['laporan_transaksi'] = $laporan_transaksi;
        $data['jumlah_pendaftaran'] = Pendaftaran::count();

        return view('laporan-transaksi.laporan-transaksi-excel', $data);
    }

    public function registerEvents(): array
    {
        $shift = config('datareferensi.kasir_shift');
        $selectedShift = $shift[array_search($this->nama_shift, array_column($shift, 'nama_shift'))];
        $awal   = $this->tanggal . ' ' . $selectedShift['waktu_mulai'];
        $akhir  = $this->tanggal . ' ' . $selectedShift['waktu_selesai'];
        $jmlData = Pendaftaran::with('pasien', 'perusahaanAsuransi', 'userKasir')
        ->whereBetween(\DB::raw('left(created_at,16)'), [$awal, $akhir])
        ->where('status_pembayaran', 1)
        ->count() + 2;
        return [
            AfterSheet::class    => function (AfterSheet $event) use ($jmlData) {
                $cellRange = 'A1:I1'; // All headers
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
