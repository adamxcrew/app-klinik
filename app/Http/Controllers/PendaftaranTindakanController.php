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

        $pendaftaran        = Pendaftaran::with('perusahaanAsuransi')->find($request->pendaftaran_id);
        $tindakan           = Tindakan::find($request->tindakan_id);

        $request['poliklinik_id'] = \Auth::user()->poliklinik_id;

        // apakah umum, BPJS atau lain
        $jenisPendaftaran   =  strtolower($pendaftaran->perusahaanAsuransi->nama_perusahaan);
        // if ($jenisPendaftaran == 'BPJS') {
        //     $jenisPendaftaran = 'Bpjs';
        // } elseif ($jenisPendaftaran == 'UMUM') {
        //     $jenisPendaftaran = 'Umum';
        // } else {
        //     $jenisPendaftaran = "Perusahaan";
        // }

        $listTarif      = $tindakan->pembagian_tarif;

        $fee_tindakan = [];
        foreach ($listTarif as $index => $item) {
            $jenis = explode('-', $index);
            if ($jenis[1] == $jenisPendaftaran) {
                $fee_tindakan[$index] = $item;
            }
        }

        // Pemberian Fee Untuk Dokter
        // $dokter = $request->dokter;
        // return $fee_tindakan['dokter-'.$jenisPendaftaran];

        $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
            'tindakan_id'       =>  $request->tindakan_id,
            'pendaftaran_id'    =>  $request->pendaftaran_id,
            'poliklinik_id'     =>  $request->poliklinik_id ?? 0,
            'jumlah_fee'        =>  $fee_tindakan['dokter-' . $jenisPendaftaran],
            'user_id'           =>  $request->dokter,
            'pelaksana'         => 'Dokter'
        ]);

        // Pemberian fee Untuk Klinik
        $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
            'tindakan_id'       =>  $request->tindakan_id,
            'pendaftaran_id'    =>  $request->pendaftaran_id,
            'poliklinik_id'     =>  $request->poliklinik_id ?? 0,
            'jumlah_fee'        =>  $fee_tindakan['klinik-' . $jenisPendaftaran],
            'pelaksana'         => 'Klinik'
        ]);

        // Pemberian Fee Untuk Asisten
        if ($request->asisten != null) {
            $pendaftaranFeeTindakan = PendaftaranFeeTindakan::create([
                'tindakan_id'       =>  $request->tindakan_id,
                'pendaftaran_id'    =>  $request->pendaftaran_id,
                'poliklinik_id'     =>  $request->poliklinik_id ?? 0,
                'jumlah_fee'        =>  $fee_tindakan['asisten-' . $jenisPendaftaran],
                'user_id'           =>  $request->asisten,
                'pelaksana'         => 'Asisten'
            ]);
        }


        // input BHP yang digunakan ketika tindakan
        $tindakanBHP = TindakanBHP::where('tindakan_id', $request->tindakan_id)->get();
        foreach ($tindakanBHP as $item) {
            $barang = Barang::find($item->barang_id);
            if ($barang != null) {
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
        }
        $request['fee'] = $tindakan['tarif_' . strtolower($jenisPendaftaran)];
        $request['qty'] = 1;

        // cek apakah tindakan iterasi
        if ($tindakan->iterasi == 1) {
            // cek apakah dia masih punya quota

            $paketIterasi = PaketIterasi::where('tindakan_id', $tindakan->id)
                            ->where('pasien_id', $pendaftaran->pasien_id)
                            ->first();


            if ($paketIterasi) {
                // kalau sudah ada maka kurangi stock nya
                $request['discount'] = $tindakan['tarif_' . strtolower($jenisPendaftaran)];
                $paketIterasi->update(['quota' => ($paketIterasi->quota - 1)]);
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

        return PendaftaranTindakan::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['pendaftaran'] = Pendaftaran::find($id);
        $data['pendaftaranTindakan'] = PendaftaranTindakan::with(['tindakan.icd','tindakan.bhp.barang'])->where('pendaftaran_id', $id);
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
        // $paketIterasi = PaketIterasi::where('tindakan_id', $pendaftaranTindakan->tindakan_id)
        // ->where('pasien_id', $pendaftaranTindakan->pendaftaran->pasien_id)->first();
        // if ($paketIterasi) {
        //     $riwayat = RiwayatPenggunaanTindakanIterasi::where('paket_iterasi_id', $paketIterasi->id)->first();
        //     if ($riwayat) {
        //         // tambahkan quota kembali yang sudah berkurang
        //         $riwayat->delete();
        //     }
        //     $paketIterasi->delete();
        // }


        $pendaftaranTindakan->delete();
        PendaftaranFeeTindakan::where('pendaftaran_id', $pendaftaranTindakan->pendaftaran_id)
        ->where('tindakan_id', $pendaftaranTindakan->tindakan_id)
        ->delete();

        \DB::table('pendaftaran_resep')
        ->where('tindakan_id', $pendaftaranTindakan->tindakan_id)
        ->where('pendaftaran_id', $pendaftaranTindakan->pendaftaran_id)
        ->delete();
    }
}
