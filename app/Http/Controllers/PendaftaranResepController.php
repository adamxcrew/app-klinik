<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\Pendaftaran;
class PendaftaranResepController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);
        $barang                     = Barang::find($request->barang_id);
        // jika jenis pelayanan bpjs dan obat umum maka set harga normal, selain itu set harga 0

        if($pendaftaran->perusahaanAsuransi->nama_perusahaan == 'BPJS' && $barang->pelayanan == 'umum')
        {
            $request['harga']           = $barang->harga_jual;
        }else{
            $request['harga']           = 0;
        }
        
        $request['pendaftaran_id']  = $request->pendaftaran_id;
        $request['satuan_terkecil_id'] = $request->satuan;
        return PendaftaranResep::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pendaftaranResep'] = PendaftaranResep::with(['barang.satuanTerkecil'])->where('jenis', '!=', 'bhp')->where('pendaftaran_id', $id);
        return view('pendaftaran.partials.daftar_resep', $data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendaftaranResep = PendaftaranResep::findOrFail($id);
        $pendaftaranResep->delete();
    }
}
