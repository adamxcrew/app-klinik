<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Tindakan;
use App\Http\Requests\TindakanStoreRequest;

class TindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Tindakan::all())
            ->addColumn('action', function ($row) {
                $btn = \Form::open(['url' => 'tindakan/' . $row->id, 'method' => 'DELETE','style' => 'float:right;margin-right:5px']);
                $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                $btn .= \Form::close();
                $btn .= '<a class="btn btn-danger btn-sm" href="/tindakan/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                return $btn;
            })
            ->addColumn('aktif', function ($row) {
                return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
            })
            ->rawColumns(['action','code'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('tindakan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tindakan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TindakanStoreRequest $request)
    {
        Tindakan::create($request->all());
        return redirect(route('tindakan.index'))->with('message', 'Data Tindakan Berhasil Disimpan');
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
        $data['tindakan'] = Tindakan::findOrFail($id);
        return view('tindakan.edit', $data);
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
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->update($request->all());
        return redirect(route('tindakan.index'))->with('message', 'Data tindakan Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tindakan = Tindakan::findOrFail($id);
        $tindakan->delete();
        return redirect(route('tindakan.index'))->with('message', 'Data tindakan Berhasil Dihapus');
    }
}
