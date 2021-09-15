<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poliklinik;
use App\Models\Pasien;
use DataTables;
use PDF;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pendaftaran::with('pasien')->with('poliklinik')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:75px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/detail">Detail</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pendaftaran.index');
    }

    public function pendaftaranCreate()
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['pasien'] = Pasien::pluck('nama', 'id');
        return view('pendaftaran.pasien-terdaftar', $data);
    }

    public function detailPasien(Request $request)
    {
        $data = Pasien::where('id', $request->id)->first();
        return $data;
    }

    public function pendaftaranInsert(Request $request)
    {
        $data = Pendaftaran::create($request->all());
        return redirect('/pendaftaran/'.$data->id.'/cetak');
    }

    public function detail($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        return view('pendaftaran.detail', $data);
    }

    public function cetak($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        return view('pendaftaran.nomor-antrian', $data);
    }

    public function print($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        $pdf = PDF::loadView('pendaftaran.cetak', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        $data = Pendaftaran::findOrFail($id);
        $data->delete();

        return redirect('/pendaftaran');
    }

    
    public function dataDiagnosa(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Diagnosa::all())
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/edit">Pilih</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function dataTindakan(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Tindakan::all())
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/edit">Pilih</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function dataObat(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Obat::all())
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/edit">Pilih</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
