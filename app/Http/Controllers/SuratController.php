<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\NomorAntrian;

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $type                   = $request->get('type');
        $data['nomorAntrian']   = NomorAntrian::with('pendaftaran.pasien')->find(1);
        $pdf = PDF::loadView('surat.buta_warna', $data);
        //return view('surat.surat_sehat');
        return $pdf->stream();
    }
}
