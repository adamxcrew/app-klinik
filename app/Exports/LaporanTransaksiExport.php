<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use App\Models\PengeluaranOperasional;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanTransaksiExport implements FromView, ShouldAutoSize, WithEvents, withTitle
{
    public $tanggal;
    public $nama_shift;
    public $poliklinik_id;
    public $metode_pembayaran;

    public function __construct($tanggal, $nama_shift, $poliklinik_id, $metode_pembayaran)
    {
        $this->tanggal          = $tanggal;
        $this->nama_shift       = $nama_shift;
        $this->poliklinik_id    = $poliklinik_id;
        $this->metode_pembayaran    = $metode_pembayaran;
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }

    public function view(): View
    {

        $shift = config('datareferensi.kasir_shift');
        $selectedShift = $shift[array_search($this->nama_shift, array_column($shift, 'nama_shift'))];
        $awal   = $this->tanggal . ' ' . $selectedShift['waktu_mulai'];
        $akhir  = $this->tanggal . ' ' . $selectedShift['waktu_selesai'];
        $laporan_transaksi = Pendaftaran::with('pasien', 'perusahaanAsuransi', 'userKasir')
            ->whereBetween(\DB::raw('left(created_at,16)'), [$awal, $akhir])
            ->where('status_pembayaran', 1);

        if ($this->metode_pembayaran != '') {
            $laporan_transaksi->where('metode_pembayaran', $this->metode_pembayaran);
        }
        $data['laporan_transaksi'] = $laporan_transaksi->get();
        $data['jumlah_pendaftaran'] = Pendaftaran::count();

        $data['pengeluaran'] = PengeluaranOperasional::all();
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
                $cellRange = 'A1:K1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getStyle('A1:K' . $jmlData)->applyFromArray([
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
