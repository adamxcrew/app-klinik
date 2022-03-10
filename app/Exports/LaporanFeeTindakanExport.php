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

    protected $tanggal_mulai;
    protected $tanggal_selesai;
    protected $poliklinik_id;

    public function __construct($tanggal_mulai, $tanggal_selesai, $poliklinik_id)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
        $this->poliklinik_id = $poliklinik_id;
    }


    public function view(): View
    {

        // $sql = "select pft.jumlah_fee,p.kode as nomor_pendaftaran,pl.nama  as nama_poliklinik,p.created_at as tanggal,pg.nama as nama_dokter
        // from pendaftaran_fee_tindakan as pft
        // join nomor_antrian as na on na.pendaftaran_id=pft.pendaftaran_id
        // join pendaftaran as p on p.id=pft.pendaftaran_id
        // join poliklinik as pl on pl.id=na.poliklinik_id
        // join pegawai as pg on pg.id=p.dokter_id;"

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
