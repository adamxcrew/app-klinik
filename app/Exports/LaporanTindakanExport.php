<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanTindakanExport implements FromView, ShouldAutoSize
{
    public $periode;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $tanggal_awal = $this->periode . '-01';
        $tanggal_akhir = $this->periode . '-31';

        $pendaftaranTindakan = DB::select(
            "SELECT users.name as dokter,pendaftaran_tindakan.created_at,poliklinik.nama as poliklinik,pasien.nomor_rekam_medis,pendaftaran_tindakan.id,pasien.nama,perusahaan_asuransi.nama_perusahaan,tindakan.tindakan, SUM(tindakan.tarif_umum) as tarif_total
            FROM pendaftaran_tindakan
            JOIN pendaftaran on pendaftaran.id = pendaftaran_tindakan.pendaftaran_id
            JOIN pasien on pasien.id = pendaftaran.pasien_id
            JOIN perusahaan_asuransi on perusahaan_asuransi.id = pendaftaran.jenis_layanan
            JOIN tindakan on tindakan.id = pendaftaran_tindakan.tindakan_id
            JOIN users on users.id = pendaftaran.dokter_id
            JOIN poliklinik on poliklinik.id = pendaftaran.poliklinik_id
            WHERE pendaftaran_tindakan.created_at BETWEEN '$tanggal_awal' AND '$tanggal_akhir'
            GROUP BY pendaftaran.id"
        );

        $data['laporanTindakan'] = $pendaftaranTindakan;

        return view('laporan-tindakan.laporan-tindakan-excel', $data);
    }
}
