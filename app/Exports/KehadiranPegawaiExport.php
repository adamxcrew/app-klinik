<?php

namespace App\Exports;

use App\Models\KehadiranPegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class KehadiranPegawaiExport implements FromView, ShouldAutoSize
{
    public $tanggal_mulai;
    public $tanggal_selesai;

    public function construct($tanggal_mulai, $tanggal_selesai)
    {
        $this->tanggal_mulai = $tanggal_mulai;
        $this->tanggal_selesai = $tanggal_selesai;
    }

    public function view(): View
    {
        \Log::info($this->tanggal_mulai);
        \Log::info($this->tanggal_selesai);
        return view('kehadiran-pegawai.laporan-kehadiran-excel', [
            'laporan_kehadiran' => KehadiranPegawai::whereBetween('tanggal', [$this->tanggal_mulai, $this->tanggal_selesai])
        ]);
    }
}
