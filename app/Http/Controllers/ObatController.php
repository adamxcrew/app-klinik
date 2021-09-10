<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Obat;
use App\Models\Satuan;
use App\Http\Requests\ObatStoreRequest;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Obat::with('satuan')->get())
          ->addColumn('action', function ($row) {
              $btn = \Form::open(['url' => 'obat/'.$row->id, 'method' => 'DELETE','style'=>'float:right;margin-right:5px']);
              $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
              $btn .= \Form::close();
              $btn .='<a class="btn btn-danger btn-sm" href="/obat/'.$row->id.'/edit"><i class="fas fa-edit" aria-hidden="true"></i></a>';
              return $btn;
          })
          ->rawColumns(['action','code'])
          ->addIndexColumn()
          ->make(true);
        }
        return view('obat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['satuan'] = Satuan::pluck('satuan', 'id');
        return view('obat.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ObatStoreRequest $request)
    {
        Obat::create($request->all());
        return redirect(route('obat.index'));
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
        $data['satuan'] = Satuan::pluck('satuan', 'id');
        return view('obat.edit', $data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
