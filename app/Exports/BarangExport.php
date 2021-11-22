<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BarangExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        $barang = Barang::with(['satuanTerbesar', 'satuanTerkecil'])->get();
        return view('barang.laporan-barang-excel', ['barangs' => $barang]);
    }
}
