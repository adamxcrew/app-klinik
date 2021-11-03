<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\JenisPemeriksaanLab;
use App\Models\IndikatorPemeriksaanLab;
use App\Http\Requests\JenisPemeriksaanLabStoreRequest;

class JenisPemeriksaanLabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(JenisPemeriksaanLab::all())
            ->addColumn('action', function ($row) {
                $btn = "<a href='/jenis-pemeriksaan-lab/" . $row->id . "/input-indikator' class='btn btn-danger btn-sm ' style='margin-right:10px'><i class='fa fa-eye'></i></a>";
                $btn .= \Form::open(['url' => 'jenis-pemeriksaan-lab/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/jenis-pemeriksaan-lab/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('jenis-pemeriksaan-laboratorium.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenis-pemeriksaan-laboratorium.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JenisPemeriksaanLabStoreRequest $request)
    {
        $jenisPemeriksaanLab = JenisPemeriksaanLab::create($request->all());
        return redirect('jenis-pemeriksaan-lab/'.$jenisPemeriksaanLab->id.'/input-indikator');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['jenisPemeriksaanLab'] = JenisPemeriksaanLab::findOrFail($id);
        return view('jenis-pemeriksaan-laboratorium.edit', $data);
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
        $jenisPemeriksaanLab = JenisPemeriksaanLab::findOrFail($id);
        $jenisPemeriksaanLab->update($request->all());
        return redirect(route('jenis-pemeriksaan-lab.index'))->with('message', 'Data jenis pemeriksaan Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jenisPemeriksaanLab = JenisPemeriksaanLab::findOrFail($id);
        $jenisPemeriksaanLab->delete();
        return redirect(route('jenis-pemeriksaan-lab.index'))->with('message', 'Data jenis pemeriksaan Berhasil Dihapus');
    }

    public function input_indikator(Request $request, $id)
    {
        $data['jenisPemeriksaan'] = JenisPemeriksaanLab::findOrFail($id);
        $data['indikatorPemeriksaan'] = IndikatorPemeriksaanLab::all();
        return view('jenis-pemeriksaan-laboratorium.indikator', $data);
    }
}
