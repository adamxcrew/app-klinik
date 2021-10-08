<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class NeracaSaldoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $jurnal = Jurnal::with('akun')->groupBy('akun_id')->whereBetween('tanggal', [$data['tanggal_awal'], $data['tanggal_akhir']])->get();
        if ($request->ajax()) {
            $collection = [];

            $i = 0;

            foreach ($jurnal as $j) {

                $debet = DB::table('jurnal')->select(DB::raw('SUM(nominal) as total'))
                    ->where('akun_id', $j->akun_id)
                    ->where('tipe', 'debet')
                    ->first();

                $credit = DB::table('jurnal')->select(DB::raw('SUM(nominal) as total'))
                    ->where('akun_id', $j->akun_id)
                    ->where('tipe', 'kredit')
                    ->first();


                $collection[$i]['id'] = $j->id;
                $collection[$i]['akun'] = $j->akun->nama;
                $collection[$i]['kode'] = $j->akun->kode;
                $collection[$i]['kredit'] = $credit->total;
                $collection[$i]['debet'] = $debet->total;

                $i++;
            }

            return DataTables::of($collection)
                ->addColumn('kredit', function ($row) {
                    return convert_rupiah($row['kredit']);
                })
                ->addColumn('debet', function ($row) {
                    return convert_rupiah($row['debet']);
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('neraca-saldo.index', $data);
    }
}
