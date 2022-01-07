<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poliklinik;
use App\Exports\LaporanKunjungan;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function laporanKunjunganPerPoli(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['laporan']        = Poliklinik::KunjunganPasienPerPoli($data['tanggal_awal'], $data['tanggal_akhir'])->get();
        if ($request->has('type')) {
            if ($request->type == 'excel') {
                $nama_file = 'laporan-kunjungan-pasien-perpoli-periode-' . $data['tanggal_awal'] . '-sampai-' . $data['tanggal_akhir'] . '.xlsx';
                return Excel::download(new LaporanKunjungan($data['tanggal_awal'], $data['tanggal_akhir']), $nama_file);
            }
        }
        return view('laporan.kunjungan-perpoli', $data);
    }
}
