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
        $data['metodePembayaran'] = ['cash' => 'Cash', 'transfer' => 'Transfer', 'debit' => 'Debit'];
        $data['userInfo'] = Pendaftaran::with(['pasien', 'perusahaanAsuransi', 'dokter', 'poliklinik'])->findOrFail($id);
        return view('pembayaran.index', $data);
    }

    public function store(PembayaranStoreRequest $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['user_id_kasir' => Auth::user()->id,'status_pembayaran' => 1, 'metode_pembayaran' => $request->metode_pembayaran, 'total_bayar' => $request->jumlah_bayar]);
        return redirect('pembayaran/' . $pendaftaran->id . '/kwitansi');
    }

    public function kwitansi($id)
    {
        $data['pendaftaran'] = Pendaftaran::with('pasien', 'perusahaanAsuransi')->where('id', $id)->first();
        $awal = substr($data['pendaftaran']->created_at, 0, 10) . " 00:00:00";
        $akhir = substr($data['pendaftaran']->created_at, 0, 10) . " 23:59:00";
        $data['tindakans'] = PendaftaranTindakan::with('tindakan', 'pendaftaran')->where('pendaftaran_id', $data['pendaftaran']->id)->whereBetween('created_at', [$awal, $akhir])->get();
        $data['penjamin'] = $data['pendaftaran']->perusahaanAsuransi->nama_perusahaan;
        $data['obats'] = PendaftaranResep::with('barang')->where('pendaftaran_id', $data['pendaftaran']->id)->get();
        $pdf = PDF::loadView('pembayaran.kwitansi', $data)->setPaper('A5', 'landscape');
        return $pdf->stream();
    }
}
