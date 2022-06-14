<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\PendaftaranFeeTindakan;
use App\Models\Pegawai;

;
use App\Exports\LaporanFeeTindakanExport;
use Excel;
use DB;
use App\Models\Poliklinik;
use App\User;
class LaporanFeeTindakanController extends Controller
{

    public function index(Request $request)
    {
        $awal = date('Y-m-d H:i:s', strtotime($request->startDate));
        $akhir = date('Y-m-d H:i:s', strtotime($request->endDate));


        $data = PendaftaranFeeTindakan::select(
            'pendaftaran.created_at as tanggal',
            'users.name as nama_pelaksana',
            'pendaftaran_fee_tindakan.pelaksana',
            'pendaftaran_fee_tindakan.jumlah_fee',
            'pendaftaran.kode as nomor_pendaftaran',
            'poliklinik.nama as unit',
            'perusahaan_asuransi.nama_perusahaan as jenis_pelayanan',
            'tindakan.tindakan as nama_tindakan'
        )
        ->join('nomor_antrian', 'nomor_antrian.pendaftaran_id', 'pendaftaran_fee_tindakan.pendaftaran_id')
        ->join('pendaftaran', 'pendaftaran.id', 'pendaftaran_fee_tindakan.pendaftaran_id')
        ->join('poliklinik', 'poliklinik.id', 'nomor_antrian.poliklinik_id')
        ->join('perusahaan_asuransi', 'perusahaan_asuransi.id', 'pendaftaran.jenis_layanan')
        ->join('tindakan', 'tindakan.id', 'pendaftaran_fee_tindakan.tindakan_id')
        ->join('users', 'users.id', 'pendaftaran_fee_tindakan.user_id')
        ->whereBetween(\DB::raw('left(nomor_antrian.created_at,10)'), [$awal,$akhir])
        ->get();

        if ($request->ajax()) {
            \Log::info($request->startDate);
            return DataTables::of($data)
            ->editColumn('tanggal', function ($row) {
                    return substr($row->tanggal, 0, 10);
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }

        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['users']      = User::where('role', 'dokter')->pluck('name', 'id');
        return view('laporan-fee-tindakan.index', $data);
    }

    public function export_excel(Request $request)
    {
        return Excel::download(new LaporanFeeTindakanExport($request->tanggal_mulai, $request->tanggal_selesai, $request->user_id, $request->poliklinik_id), 'LaporanFeeTindakan.xlsx');
    }
}
