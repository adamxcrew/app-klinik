<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsuransiStoreRequest;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Asuransi;

class AsuransiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Asuransi::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'asuransi/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/asuransi/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('perusahaan-asuransi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perusahaan-asuransi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsuransiStoreRequest $request)
    {
        Asuransi::create($request->all());
        return redirect(route('asuransi.index'));
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
        $data['asuransi'] = Asuransi::findOrFail($id);
        return view('perusahaan-asuransi.edit', $data);
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
        $asuransi = Asuransi::findOrFail($id);
        $asuransi->update($request->all());
        return redirect(route('asuransi.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asuransi = Asuransi::findOrFail($id);
        $asuransi->delete();
        return redirect(route('asuransi.index'))->with('message', 'Data Berhasil Dihapus');
    }
}
