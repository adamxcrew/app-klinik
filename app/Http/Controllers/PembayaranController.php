<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Http\Requests\PembayaranStoreRequest;

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
}
