<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTransaksiExport;
use App\Models\Pendaftaran;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
            ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$awal, $akhir])
            ->where('status_pembayaran', 1);

        if ($request->ajax()) {
            return DataTables::of($pendaftaran->get())
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo(substr($row->created_at, 0, 10));
                })
                ->addColumn('jenis_layanan', function ($row) {
                    return $row->perusahaanAsuransi->nama_perusahaan;
                })
                ->addColumn('total_transaksi', function ($row) {
                    return convert_rupiah($row->total_bayar);
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/pembayaran/' . $row->id . '/kwitansi"><i class="fa fa-print"></i> Kwitansi</a></div>';
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }

        $data['shift'] = config('datareferensi.kasir_shift');
        return view('laporan-transaksi.index', $data);
    }

    public function export(Request $request)
    {
        return Excel::download(new LaporanTransaksiExport($request->tanggal, $request->nama_shift), 'Laporan Transaksi ' . date('Y-m-d') . '.xlsx');
    }
}
