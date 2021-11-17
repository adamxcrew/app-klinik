<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\PendaftaranPemeriksaanGigi;
use Illuminate\Http\Request;

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
}
