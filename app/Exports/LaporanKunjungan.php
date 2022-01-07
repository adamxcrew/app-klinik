<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\LaporanKunjunganPasien;
use App\Exports\KunjunganPasienPerPoliExport;

class LaporanKunjungan implements WithMultipleSheets
{
    public $periode_awal;
    public $periode_akhir;

    public function __construct($periode_awal, $periode_akhir)
    {
        $this->periode_awal = $periode_awal;
        $this->periode_akhir = $periode_akhir;
    }
    /**
    * @return \Illuminate\Support\Collection
    */


    public function sheets(): array
    {
        return [
            new KunjunganPasienPerPoliExport($this->periode_awal, $this->periode_akhir),
            new LaporanKunjunganPasien($this->periode_awal, $this->periode_akhir)
        ];
    }
}
