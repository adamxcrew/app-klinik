<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatatanHarian;

class PendaftaranCatatanHarianController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return CatatanHarian::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['catatanHarian'] = CatatanHarian::where('pendaftaran_id', $id);
        return view('pendaftaran.partials.daftar_catatan_harian', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CatatanHarian::findOrFail($id);
        $data->delete();
    }
}
