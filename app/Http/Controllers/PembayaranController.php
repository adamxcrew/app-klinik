<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Http\Requests\PembayaranStoreRequest;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use PDF;
use Auth;

class PembayaranController extends Controller
{
    public function index($id)
    {
        $data['metodePembayaran']   = ['cash' => 'Cash', 'transfer' => 'Transfer', 'debit' => 'Debit','piutang' => 'Piutang'];
        $data['userInfo']           = Pendaftaran::with(['pasien', 'perusahaanAsuransi', 'dokter', 'poliklinik','obatRacik.detail.barang'])->findOrFail($id);
        return view('pembayaran.index', $data);
    }

    public function store(PembayaranStoreRequest $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update([
            'user_id_kasir'         => Auth::user()->id,
            'status_pembayaran'     => 1,
            'status_pelayanan'      => 'selesai_pembayaran',
            'metode_pembayaran'     => $request->metode_pembayaran,
            'jumlah_bayar'           => $request->jumlah_bayar,
            'total_bayar'           => $request->total_bayar,
            'biaya_tambahan'        =>  $request->biaya_tambahan
        ]);

        return redirect('pembayaran/' . $pendaftaran->id . '/kwitansi');
    }

    public function kwitansi($id)
    {
        $data['pendaftaran']    = Pendaftaran::with('pasien', 'perusahaanAsuransi')->where('id', $id)->first();
        $awal                   = substr($data['pendaftaran']->created_at, 0, 10) . " 00:00:00";
        $akhir                  = substr($data['pendaftaran']->created_at, 0, 10) . " 23:59:00";
        $data['tindakans']      = PendaftaranTindakan::with('tindakan', 'pendaftaran')->where('pendaftaran_id', $data['pendaftaran']->id)->get();
        $data['penjamin']       = $data['pendaftaran']->perusahaanAsuransi->nama_perusahaan;
        $data['bhps']           = PendaftaranResep::with('barang')->where('jenis', 'bhp')
                                ->where('pendaftaran_id', $data['pendaftaran']->id)
                                ->get();
        $data['nonRaciks']      = PendaftaranResep::with('barang')->where('jenis', 'non racik')
                                ->where('pendaftaran_id', $data['pendaftaran']->id)
                                ->get();
        $data['obatRacik']      = \App\Models\PendaftaranObatRacik::with('detail.barang')->where('pendaftaran_id', $id)->get();
        $pdf                    = PDF::loadView('pembayaran.kwitansi', $data)->setPaper('A5', 'landscape');
        return $pdf->stream();
    }
}
