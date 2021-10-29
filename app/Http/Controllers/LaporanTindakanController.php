<?php

namespace App\Http\Controllers;

use App\User;
use DataTables;
use App\Models\Poliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTindakanExport;

class LaporanTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['periode'] = $request->periode ?? date('Y-m');

        $pendaftaranTindakan = DB::select(
            "SELECT pendaftaran_tindakan.created_at,pendaftaran.poliklinik_id,pendaftaran.dokter_id,pasien.nomor_rekam_medis,pendaftaran_tindakan.id,pasien.nama,perusahaan_asuransi.nama_perusahaan,tindakan.tindakan, SUM(tindakan.tarif_umum) as tarif_total
            FROM pendaftaran_tindakan
            JOIN pendaftaran on pendaftaran.id = pendaftaran_tindakan.pendaftaran_id
            JOIN pasien on pasien.id = pendaftaran.pasien_id
            JOIN perusahaan_asuransi on perusahaan_asuransi.id = pendaftaran.jenis_layanan
            JOIN tindakan on tindakan.id = pendaftaran_tindakan.tindakan_id
            GROUP BY pendaftaran.id"
        );

        if ($request->ajax()) {
            return DataTables::of($pendaftaranTindakan)
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'laporan-tindakan/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/laporan-tindakan/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->addColumn('dokter', function ($row) {
                    $dokter = User::findOrFail($row->dokter_id);
                    return $dokter->name;
                })
                ->addColumn('poliklinik', function ($row) {
                    $poliklinik = Poliklinik::findOrFail($row->poliklinik_id);
                    return $poliklinik->nama;
                })
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo(substr($row->created_at, 0, 10));
                })
                ->addColumn('tarif_total', function ($row) {
                    return convert_rupiah($row->tarif_total);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            if ($request->action == 'download') {
                return Excel::download(new LaporanTindakanExport($request->periode), 'Laporan Tindakan ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
        }

        return view('laporan-tindakan.index', $data);
    }
}
