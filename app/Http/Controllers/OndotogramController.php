<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\PendaftaranTindakan;
use App\Models\Tindakan;
use Illuminate\Http\Request;
use PDF;
use App\Models\Satuan;

class OndotogramController extends Controller
{
    public function index($pendaftaranId)
    {
        $data['pendaftaran'] = Pendaftaran::findOrFail($pendaftaranId);
        $data['pendaftaran_gigi'] = PendaftaranTindakan::with(['tbm', 'tindakan'])->where('pendaftaran_id', $pendaftaranId)->get();
        $data['total'] = count($data['pendaftaran_gigi']);
        $data['satuan']                 = Satuan::pluck('satuan', 'id');
        return view('ondotogram.index', $data);
    }

    public function store(Request $request)
    {
        $pendaftaran = Pendaftaran::with('perusahaanAsuransi')->findOrFail($request->pendaftaran_id);
        $tindakan = Tindakan::findOrFail($request->tindakan_id);

        if ($pendaftaran->perusahaanAsuransi->nama_perusahaan == 'UMUM') {
            $fee = $tindakan->tarif_umum;
        } else if ($pendaftaran->perusahaanAsuransi->nama_perusahaan == 'BPJS') {
            $fee = $tindakan->tarif_bpjs;
        } else {
            $fee = $tindakan->tarif_perusahaan;
        }

        $request['fee'] = $fee;
        $stored = PendaftaranTindakan::create($request->all());
        $result = PendaftaranTindakan::with(['tbm', 'tindakan'])->where('id', $stored->id)->first();
        $response = [
            "success" => true,
            "message" => "Data berhasil ditambahkan",
            "data" => $result
        ];
        return response($response, 201);
    }

    public function print($pendaftaranId)
    {
        $data['pendaftaran'] = PendaftaranTindakan::with(['tbm', 'pendaftaran'])->where('pendaftaran_id', $pendaftaranId)->get();
        $date_birth = $data['pendaftaran'][0]->pendaftaran->pasien->tanggal_lahir;
        $date_now = date('Y-m-d');
        $date_diff = date_diff(date_create($date_birth), date_create($date_now));
        $data['umur'] = $date_diff->format('%y');

        \DB::table('pendaftaran')
        ->where('id', $pendaftaranId)
        ->update(['status_pelayanan' => 'selesai']);

        $pdf = PDF::loadView('ondotogram.cetak-hasil', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        PendaftaranTindakan::where('id', $id)->delete();
        $response = [
            "success" => true,
            "message" => "Data berhasil dihapus",
        ];
        return response($response, 200);
    }
}
