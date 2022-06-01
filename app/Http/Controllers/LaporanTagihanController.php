<?php

namespace App\Http\Controllers;

use App\Exports\LaporanTagihanExport;
use Illuminate\Http\Request;
use DataTables;
use App\Models\PendaftaranTindakan;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PerusahaanAsuransi;
use App\Models\ViewLaporanPendaftaranTindakan;

class LaporanTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['periode'] = $request->periode ?? date('Y-m');

        // select cast(na.created_at as date) as tanggal,
        // p.nomor_rekam_medis,
        // p.nama as nama_pasien,
        // pa.nama_perusahaan as perusahaan_asuransi,
        // t.tindakan as nama_tindakan,
        // pk.nama as poliklinik,
        // pt.fee as biaya_tindakan,pt.qty,pt.discount,
        // (pt.fee-pt.discount)*pt.qty as tarif_total
        // from nomor_antrian as na
        // join pendaftaran as pd on pd.id=na.pendaftaran_id
        // join pendaftaran_tindakan as pt on na.pendaftaran_id=pt.pendaftaran_id
        // join pasien as p on p.id=pd.pasien_id
        // join poliklinik as pk on pk.id=na.poliklinik_id
        // join perusahaan_asuransi as pa on pa.id=pd.jenis_layanan
        // join tindakan as t on t.id=pt.tindakan_id;





        $laporanTagihan = ViewLaporanPendaftaranTindakan::query();

        if ($request->periode) {
            $laporanTagihan->whereRaw("left(tanggal,7)='" . $request->periode . "'");
        }

        if ($request->has('nama_perusahaan')) {
            if ($request->nama_perusahaan != '') {
                $laporanTagihan->where('jenis_layanan', $request->nama_perusahaan);
            }
        }

        if ($request->ajax()) {
            return DataTables::of($laporanTagihan)
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            if ($request->action == 'download') {
                return Excel::download(new LaporanTagihanExport($request->periode, $request->nama_perusahaan ?? null), 'Laporan Tagihan Perusahaan ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
        }

        $data['perusahaan'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        return view('laporan-tagihan.index', $data);
    }
}
