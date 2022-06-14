<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\LaporanKunjunganPasien;
use App\Exports\KunjunganPasienPerPoliExport;

class LaporanTransaksiAllExport implements WithMultipleSheets
{
    public $tanggal;
    public $nama_shift;
    public $poliklinik_id;

    public function __construct($tanggal, $nama_shift, $poliklinik_id)
    {
        $this->tanggal = $tanggal;
        $this->nama_shift = $nama_shift;
        $this->poliklinik_id = $poliklinik_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */


    public function sheets(): array
    {
        return [
            new LaporanTransaksiExport($this->tanggal, $this->nama_shift, $this->poliklinik_id),
            new LaporanPengeluaranExport($this->tanggal, $this->nama_shift, $this->poliklinik_id)
        ];
    }
}
