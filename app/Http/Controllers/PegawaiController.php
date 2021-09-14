<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Pegawai;
use App\Http\Requests\PegawaiStoreRequest;
use App\Models\Agama;

class PegawaiController extends Controller
{
    protected $kelompokPegawai;


    public function __construct()
    {
        $this->kelompokPegawai = config('datareferensi.kelompok_pegawai');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pegawai::with('agama')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pegawai/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pegawai/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
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
        $data['agama']              = Agama::pluck('agama', 'id');
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
        $data['akun'] = Akun::findOrFail($id);
        return view('akun.show', $data);
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
        $data['agama']              = Agama::pluck('agama', 'id');
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
}
