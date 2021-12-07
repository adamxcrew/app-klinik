<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');

        $awal = date('Y-m-d H:i:s', strtotime($data['tanggal_awal']));
        $akhir = date('Y-m-d H:i:s', strtotime($data['tanggal_akhir']));

        $pendaftaran = Pendaftaran::with('pasien', 'perusahaanAsuransi')
            ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$awal, $akhir]);

        if ($request->ajax()) {
            return DataTables::of($pendaftaran->get())
                ->addColumn('jenis_layanan', function ($row) {
                    return $row->perusahaanAsuransi->nama_perusahaan;
                })
                ->addColumn('total_transaksi', function ($row) {
                    // Deklarasi variabel untuk menampung data
                    $biaya_tindakan = null;
                    $biaya_obat = null;

                    // Cari tindakan & obat by pendaftaran_id
                    $tindakans = PendaftaranTindakan::where('pendaftaran_id', $row->id)->get();
                    $obats = PendaftaranResep::where('pendaftaran_id', $row->id)->get();

                    // Looping hasil dan Masukan fee ke $biaya_tindakan
                    foreach ($tindakans as $tindakan) {
                        $biaya_tindakan += $tindakan->fee;
                    }

                    // Looping hasil dan Masukan harga ke $biaya_obat
                    foreach ($obats as $obat) {
                        $biaya_obat += $obat->harga;
                    }

                    // Menjumlahkan total hasil dari $biaya_tindakan dan $biaya_obat
                    $total = $biaya_tindakan + $biaya_obat;

                    return convert_rupiah($total);
                })
                ->addIndexColumn()
                ->make(true);
        }

        return view('laporan-transaksi.index', $data);
    }
}
