<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranTindakan;
use App\Models\Pendaftaran;
use App\Models\Tindakan;
use App\Models\PendaftaranFeeTindakan;
use App\Models\PaketIterasi;
use App\Models\TindakanBHP;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\RiwayatPenggunaanTindakanIterasi;

class PendaftaranTindakanController extends Controller
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
        $jenisPendaftaran = $pendaftaran->perusahaanAsuransi->nama_perusahaan;
        if ($jenisPendaftaran != 'Umum' && $jenisPendaftaran != 'umum') {
            if ($jenisPendaftaran == 'BPJS' || $jenisPendaftaran == 'bpjs' || $jenisPendaftaran == 'Bpjs') {
                $jenisPendaftaran = 'Bpjs';
            } else {
                $jenisPendaftaran = 'Perusahaan';
            }
        }

        $tindakan = Tindakan::find($request->tindakan_id);
        $listTarif = $tindakan->pembagian_tarif;
        $fee_tindakan = [];
        foreach ($listTarif as $index => $item) {
            $jenis = explode('-', $index);
            if ($jenis[1] == $jenisPendaftaran) {
                $fee_tindakan[$index] = $item;
            }
        }


        $user_id = [$request->dokter, $request->asisten];
        $pelaksana = ['Dokter', 'Asisten'];
        $jumlah_fee = [
            $fee_tindakan['dokter-' . $jenisPendaftaran],
            $fee_tindakan['asisten_perawat-' . $jenisPendaftaran]
        ];

        $pendaftaran_fee_tindakan['tindakan_id'] = $request->tindakan_id;
        $pendaftaran_fee_tindakan['pendaftaran_id'] = $request->pendaftaran_id;
        $pendaftaran_fee_tindakan['jenis'] = $jenisPendaftaran;


        foreach ($user_id as $index => $item) {
            $pendaftaran_fee_tindakan['user_id'] = $item;
            $pendaftaran_fee_tindakan['pelaksana'] = $pelaksana[$index];
            $pendaftaran_fee_tindakan['jumlah_fee'] = $jumlah_fee[$index];
            PendaftaranFeeTindakan::create($pendaftaran_fee_tindakan);
        }

        $request['fee'] = $tindakan['tarif_' . strtolower($jenisPendaftaran)];
        $request['qty'] = 1;

        if ($tindakan->iterasi == 1) {
            // cek apakah dia masih punya quota

            $paketIterasi = PaketIterasi::where('pendaftaran_id', $pendaftaran->id)->where('tindakan_id', $tindakan->id)->first();
            if ($paketIterasi) {
                // kalau sudah ada maka kurangi stock nya
            } else {
                $request['pasien_id'] = $pendaftaran->pasien_id;
                $request['quota'] = $tindakan->quota;
                //return $request->all();
                $paketIterasi = PaketIterasi::create($request->all());
                $request['paket_iterasi_id'] = $paketIterasi->id;
                // set sisa quota dikurang 1 karna sedang digunakan
                $request['quota'] = $tindakan->quota - 1;
                RiwayatPenggunaanTindakanIterasi::create($request->all());
                // set quota yang akan ditagihkan sesuai dengan data master
                $request['qty'] = $tindakan->quota;
            }
        }

        // input BHP yang digunakan ketika tindakan
        $tindakanBHP = TindakanBHP::where('tindakan_id', $request->tindakan_id)->get();
        foreach ($tindakanBHP as $item) {
            $barang = Barang::find($item->barang_id);
            PendaftaranResep::create([
                'pendaftaran_id'        =>  $request->pendaftaran_id,
                'barang_id'             =>  $item->barang_id,
                'jumlah'                =>  $item->jumlah,
                'satuan_terkecil_id'    =>  $barang->satuan_terkecil_id,
                'aturan_pakai'          =>  '-',
                'jenis'                 =>  'bhp',
                'tindakan_id'           => $request->tindakan_id,
                'harga'                 =>  $barang->harga_jual,
            ]);
        }
        PendaftaranTindakan::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pendaftaranTindakan'] = PendaftaranTindakan::with(['tindakan.icd'])->where('pendaftaran_id', $id);
        return view('pendaftaran.partials.daftar_tindakan', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $pendaftaranTindakan = PendaftaranTindakan::with('pendaftaran')->findOrFail($id);
        $paketIterasi = PaketIterasi::where('pendaftaran_id', $pendaftaranTindakan->pendaftaran_id)
                    ->where('tindakan_id', $pendaftaranTindakan->tindakan_id)->first();
        if ($paketIterasi) {
            $riwayat = RiwayatPenggunaanTindakanIterasi::where('paket_iterasi_id', $paketIterasi->id)->first();
            if ($riwayat) {
                $riwayat->delete();
            }
            $paketIterasi->delete();
        }

        $pendaftaranTindakan->delete();
        \DB::table('pendaftaran_resep')
        ->where('tindakan_id',$pendaftaranTindakan->tindakan_id)
        ->where('pendaftaran_id',$pendaftaranTindakan->pendaftaran_id)
        ->delete();
    }
}
