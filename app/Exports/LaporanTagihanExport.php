<?php

namespace App\Exports;

use App\Models\PendaftaranTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTagihanExport implements FromView, ShouldAutoSize
{
    public $periode;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $start = $this->periode . '-01';
        $end = $this->periode . '-30';

        $laporanTagihan = PendaftaranTindakan::with(['pendaftaran', 'tindakan'])
            ->whereBetween('created_at', [$start, $end])
            ->get();

        return view('laporan-tagihan.laporan-tagihan-perusahaan-excel', compact('laporanTagihan'));
    }
}
