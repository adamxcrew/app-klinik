<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\KategoriBiaya;
use App\Http\Requests\KategoriBiayaStoreRequest;

class KategoriBiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(KategoriBiaya::all())
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'kategoribiaya/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/kategoribiaya/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->addColumn('aktif', function ($row) {
                return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('kategoribiaya.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategoribiaya.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KategoriBiayaStoreRequest $request)
    {
        KategoriBiaya::create($request->all());
        return redirect(route('kategoribiaya.index'));
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
        $data['kategoribiaya'] = KategoriBiaya::findOrFail($id);
        return view('kategoribiaya.edit', $data);
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
        $kategoribiaya = KategoriBiaya::findOrFail($id);
        $kategoribiaya->update($request->all());
        return redirect(route('kategoribiaya.index'))->with('message', 'Data kategori biaya Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategoribiaya = KategoriBiaya::findOrFail($id);
        $kategoribiaya->delete();
        return redirect(route('kategoribiaya.index'))->with('message', 'Data kategori biaya Berhasil Dihapus');
    }
}
