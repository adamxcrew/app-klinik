<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Pasien;
use App\Http\Requests\PasienStoreRequest;
use App\Models\Poliklinik;
use App\Models\Pendaftaran;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use PDF;

class PasienController extends Controller
{
    protected $agama;
    protected $jenjang_pendidikan;

    public function __construct()
    {
        $this->agama              = config('datareferensi.agama');
        $this->jenjang_pendidikan = config('datareferensi.jenjang_pendidikan');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pasien::all())
                ->addColumn('tempat_tanggal_lahir', function ($row) {
                    return $row->tempat_lahir . ', ' . $row->tanggal_lahir;
                })
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pasien/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    // $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/diagnosa"><i class="fa fa-user" aria-hidden="true"></i></a>';
                    // $btn .= '<a title="Pendaftaran Baru" class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pasien.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['agama']      = $this->agama;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        return view('pasien.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PasienStoreRequest $request)
    {
        $data               =   $request->all();
        $pasien             =   Pasien::create($data);
        $data['pasien_id']  =   $pasien->id;
        $pendaftaran        =   Pendaftaran::create($data);
        return redirect(route('pasien.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pasien'] = Pasien::findOrFail($id);
        $data['agama'] = $this->agama;
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        return view('pasien.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pasien'] = Pasien::findOrFail($id);
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['agama']  = $this->agama;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        return view('pasien.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());
        return redirect(route('pasien.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        return redirect(route('pasien.index'))->with('message', 'Data Berhasil Dihapus');
    }

    public function pasienDiagnosa(Request $request, $id)
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

        $data['pasien'] = Pendaftaran::findOrFail($id);
        return view('pasien.diagnosa', $data);
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

    public function pasienAntri(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pendaftaran::with('pasien')->with('poliklinik')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pasien-antri/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:75px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien-antri/' . $row->id . '/detail">Detail</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pasien.antri');
    }

    public function pasienDetail($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        return view('pasien.detail', $data);
    }

    public function pasienCetak($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        $pdf = PDF::loadView('pasien.cetak', $data);
        return $pdf->stream();
    }

    public function pasienTerdaftar()
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['pasien'] = Pasien::pluck('nama', 'id');
        return view('pasien.pasien-terdaftar', $data);
    }

    public function detailPasien(Request $request)
    {
        $data = Pasien::where('id', $request->id)->first();
        return $data;
    }

    public function pasienInsert(Request $request)
    {
        $data = Pendaftaran::create($request->all());
        return redirect('/pasien-antri/'.$data->id.'/detail');
    }

    public function pasienDelete($id)
    {
        $data = Pendaftaran::findOrFail($id);
        $data->delete();

        return redirect('/pasien-antri');
    }
}
