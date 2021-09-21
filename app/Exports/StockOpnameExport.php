<?php

namespace App\Exports;

use App\Models\StockOpname;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StockOpnameExport implements FromView, ShouldAutoSize
{
    public $tanggal_mulai;
    public $tanggal_selesai;

    public function __construct($tanggal_mulai, $tanggal_selesai)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function view(): View
    {
        $stock_opnames = StockOpname::with('barang')
            ->whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai])
            ->get();
        return view('stock-opname.laporan-stock-opname-excel', ['stock_opnames' => $stock_opnames]);
    }
}
