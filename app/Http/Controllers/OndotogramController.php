<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\PendaftaranPemeriksaanGigi;
use Illuminate\Http\Request;
use PDF;

class OndotogramController extends Controller
{
    public function index($pendaftaranId)
    {
        $data['pendaftaran'] = Pendaftaran::findOrFail($pendaftaranId);
        $data['pendaftaran_gigi'] = PendaftaranPemeriksaanGigi::with('tbm')->where('pendaftaran_id', $pendaftaranId)->get();
        $data['total'] = count($data['pendaftaran_gigi']);

        return view('ondotogram.index', $data);
    }

    public function store(Request $request)
    {
        $stored = PendaftaranPemeriksaanGigi::create($request->all());
        $pendaftaran = PendaftaranPemeriksaanGigi::with('tbm')->where('id', $stored->id)->first();
        $response = [
            "success" => true,
            "message" => "Data berhasil ditambahkan",
            "data" => $pendaftaran
        ];
        return response($response, 201);
    }

    public function print($pendaftaranId)
    {
        $data['pendaftaran'] = PendaftaranPemeriksaanGigi::with(['tbm', 'pendaftaran'])->where('pendaftaran_id', $pendaftaranId)->get();
        $date_birth = $data['pendaftaran'][0]->pendaftaran->pasien->tanggal_lahir;
        $date_now = date('Y-m-d');
        $date_diff = date_diff(date_create($date_birth), date_create($date_now));
        $data['umur'] = $date_diff->format('%y');
        $pdf = PDF::loadView('ondotogram.cetak-hasil', $data);

        return $pdf->stream();
    }
}
