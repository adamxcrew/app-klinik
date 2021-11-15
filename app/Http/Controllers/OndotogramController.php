<?php

namespace App\Http\Controllers;

use App\PendaftaranPemeriksaanGigi;
use Illuminate\Http\Request;

class OndotogramController extends Controller
{
    public function index($pendaftaranId)
    {
        $data['pendaftaranId'] = $pendaftaranId;
        return view('ondotogram.index', $data);
    }

    public function store(Request $request)
    {
        $pendaftaran = PendaftaranPemeriksaanGigi::create($request->all());
        $response = [
            "success" => true,
            "message" => "Data berhasil ditambahkan",
            "data" => $pendaftaran
        ];
        return response($response, 201);
    }
}
