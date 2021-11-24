<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Http\Requests\PembayaranStoreRequest;
use PDF;

class PembayaranController extends Controller
{
    public function index($id)
    {
        $data['metodePembayaran'] = ['cash' => 'Cash', 'transfer' => 'Transfer', 'debit' => 'Debit'];
        $data['userInfo'] = Pendaftaran::with(['pasien', 'perusahaanAsuransi', 'dokter', 'poliklinik'])->findOrFail($id);
        return view('pembayaran.index', $data);
    }

    public function store(PembayaranStoreRequest $request)
    {
        return "Pembayaran sukses";
    }

    public function kwitansi($id)
    {
        $pdf = PDF::loadView('pembayaran.kwitansi');
        return $pdf->stream();
    }
}
