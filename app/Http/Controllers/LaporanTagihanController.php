<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Http\Requests\AkunStoreRequest;

class LaporanTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Akun::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'akun/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/akun/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            if ($request->action == 'download') {
                dd('download action');
                return Excel::download(new NeracaSaldoExport($request->periode), 'Laporan Neraca Saldo ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
            if ($request->action == 'filter') {
                dd('filter action');
                return Excel::download(new NeracaSaldoExport($request->periode), 'Laporan Neraca Saldo ' . date('F Y', strtotime($request->periode)) . '.xlsx');
            }
        }

        return view('laporan-tagihan.index');
    }
}
