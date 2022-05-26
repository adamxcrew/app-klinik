<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\PendaftaranObatRacik;
use App\Models\PendaftaranObatRacikDetail;
use Session;

class PendaftaranResepRacikController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jml_item_obat = count($request->jumlah_kemasan);
        for ($i = 1; $i <= $jml_item_obat; $i++) {
            $dataObatRacik = [
                'pendaftaran_id' => $request->pendaftaran_id,
                'jumlah_kemasan' => $request->jumlah_kemasan[$i][0],
                'aturan_pakai' => $request->aturan_pakai[$i][0],
                'kemasan' => $request->jenis_kemasan[$i][0]
            ];
            $pendaftaranObatRacik = PendaftaranObatRacik::create($dataObatRacik);
            $barang = $request->barang_id[$i];
            $index = 0;
            foreach ($barang as $item) {
                $baramItem = Barang::findOrFail((int)$request->barang_id[$i][$index]);
                $detailData = [
                    'pendaftaran_obat_racik_id' => $pendaftaranObatRacik->id,
                    'harga' => $baramItem->harga_jual,
                    'barang_id' => (int)$request->barang_id[$i][$index],
                    'jumlah' => (int)$request->jumlah[$i][$index],
                ];

                //return $detailData;

                PendaftaranObatRacikDetail::insert($detailData);
                $index++;
            }
        }
        if ($request->page == 'ondotogram') {
            return redirect('ondotogram/' . $request->pendaftaran_id);
        }
        return redirect('pendaftaran/' . $request->pendaftaran_id . '/pemeriksaan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pendaftaranResepRacik'] = PendaftaranObatRacik::with('detail.barang')->where('pendaftaran_id', $id);
        return view('pendaftaran.partials.daftar_resep_racik', $data);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pendaftaranResep = PendaftaranObatRacik::findOrFail($id);
        $pendaftaranResep->delete();
    }

    public function addKomposisi(Request $request)
    {
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        $data['komposisi_item'] = rand(2, 1000);
        $data['id'] = $request->id;
        return view('pendaftaran.partials.add_komposisi_form', $data);
    }

    public function addObatRacikForm(Request $request)
    {
        $index_table = Session::get('index_table') == null ? 2 : Session::get('index_table') + 1;
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        $data['table_item'] = rand(2, 1000);
        $data['id'] = $index_table;
        $data['satuan']             = Satuan::pluck('satuan', 'id');
        return view('pendaftaran.partials.add_obat_racik_form', $data);
    }
}
