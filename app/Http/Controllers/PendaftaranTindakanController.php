<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranTindakan;
use App\Models\Pendaftaran;
use App\Models\Tindakan;
use App\Models\PendaftaranFeeTindakan;

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
        $pendaftaranTindakan = PendaftaranTindakan::findOrFail($id);
        $pendaftaranTindakan->delete();
    }
}
