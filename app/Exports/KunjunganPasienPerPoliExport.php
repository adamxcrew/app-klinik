<?php

namespace App\Exports;

use App\Models\Poliklinik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KunjunganPasienPerPoliExport implements FromView, ShouldAutoSize
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
}
