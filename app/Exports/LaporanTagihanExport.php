<?php

namespace App\Exports;

use App\Models\PendaftaranTindakan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTagihanExport implements FromView, ShouldAutoSize
{
    public $periode;
    public $perusahaan;

    public function __construct($periode, $perusahaan = null)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $laporanTagihan = PendaftaranTindakan::with(['pendaftaran', 'tindakan'])
            ->whereRaw("left(created_at,7)='" . $this->periode . "'");

        if ($this->perusahaan != null) {
            $jenis_layanan = $this->nama_perusahaan;
            $laporanTagihan->whereHas('pendaftaran', function ($query) use ($jenis_layanan) {
                return $query->where('pendaftaran.jenis_layanan', '=', $jenis_layanan);
            });
        }
        $laporanTagihan = $laporanTagihan->get();

        return view('laporan-tagihan.laporan-tagihan-perusahaan-excel', compact('laporanTagihan'));
    }
}
