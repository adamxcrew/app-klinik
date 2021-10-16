<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\PendaftaranFeeTindakan;
use App\Exports\LaporanFeeTindakanExport;
use Excel;
use DB;

class LaporanFeeTindakanController extends Controller
{
    public function dataLaporan($start = null, $end = null)
    {
        $awal = date('Y-m-d H:i:s', strtotime($start));
        $akhir = date('Y-m-d H:i:s', strtotime($end));
        $data = PendaftaranFeeTindakan::with(['tindakan', 'pendaftaran', 'user']);
        if($start != null && $end != null){
            $data->whereBetween(DB::raw('DATE(pendaftaran_fee_tindakan.created_at)'), [$awal, $akhir]);
        }

        return DataTables::of($data->get())
            ->editColumn('tanggal', function($row){
                return tgl_indo(date('Y-m-d', strtotime($row->created_at)));
            })
            ->editColumn('jumlah_fee', function($row){
                return convert_rupiah($row->jumlah_fee);
            })
            ->editColumn('jenis_pelayanan', function($row){
                return 'Umum';
            })
            ->editColumn('nomor_pendaftaran', function($row){
                return $row->pendaftaran->kode;
            })
            ->editColumn('nama_tindakan', function($row){
                return $row->tindakan->tindakan;
            })
            ->editColumn('nama_pelaksana', function($row){
                return $row->user->nama;
            })
            ->editColumn('unit', function($row){
                return $row->pendaftaran->poliklinik->nama;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->dataLaporan($request->startDate, $request->endDate);
        }
        
        return view('laporan-fee-tindakan.index');
    }

    public function export_excel()
    {
        return Excel::download(new LaporanFeeTindakanExport(), 'LaporanFeeTindakan.xlsx');
    }
}
