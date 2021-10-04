<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\KomponenGaji;
use App\Http\Requests\PegawaiStoreRequest;
use App\Models\Shift;

class PegawaiController extends Controller
{
    protected $kelompokPegawai;
    protected $agama;

    public function __construct()
    {
        $this->kelompokPegawai = config('datareferensi.kelompok_pegawai');
        $this->agama           = config('datareferensi.agama');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pegawai::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pegawai/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:15px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pegawai/' . $row->id . '?tab=komponen_gaji"><i class="fa fa-eye"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pegawai/' . $row->id . '/edit"><i class="fa fa-edit"></i></a> ';
                    return $btn;
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('pegawai.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['kelompok_pegawai']   = $this->kelompokPegawai;
        $data['agama']              = $this->agama;
        return view('pegawai.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PegawaiStoreRequest $request)
    {
        Pegawai::create($request->all());
        return redirect(route('pegawai.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pegawai'] = Pegawai::findOrFail($id);
        $data['komponen_gaji'] = KomponenGaji::pluck('nama_komponen', 'id');
        return view('pegawai.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['kelompok_pegawai']   = $this->kelompokPegawai;
        $data['agama']              = $this->agama;
        $data['pegawai']            = Pegawai::findOrFail($id);
        return view('pegawai.edit', $data);
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
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());
        return redirect(route('pegawai.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return redirect(route('pegawai.index'))->with('message', 'Data Berhasil Dihapus');
    }

    public function aturJadwal()
    {
        $data['shift']   = Shift::pluck('nama_shift', 'id');
        return view('pegawai.atur-jadwal', $data);
    }

    public function aturJadwalStore(Request $request)
    {
        dd($request->all());
    }
}
