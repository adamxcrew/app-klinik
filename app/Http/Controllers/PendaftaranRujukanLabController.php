<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RujukanInternal;
use App\Models\Pendaftaran;
use DataTables;
use App\Models\NomorAntrian;

class PendaftaranRujukanLabController extends Controller
{
    public function store(Request $request)
    {
        $pendaftaran                = Pendaftaran::find($request->pendaftaran_id);
        $request['users_id']        = $request->user_id;
        $request['pasien_id']       = $pendaftaran->pasien_id;
        $request['pendaftaran_id']  = $pendaftaran->id;
        $request['tindakan_id']     = $request->jenis_pemeriksaan_laboratorium_id;
        $request['catatan']         = $request->catatan;
        $request['status']          = "Proses Pemeriksaan";
        RujukanInternal::create($request->all());
                // create nomor antrian
        $nomor = NomorAntrian::where('poliklinik_id', $request->poliklinik_id)
                ->whereDate('created_at', date('Y-m-d'))
                ->max('nomor_antrian');
                $nomorAntrianData = [
                'pendaftaran_id'    =>  $request->pendaftaran_id,
                'poliklinik_id'     =>  $request->poliklinik_id,
                'nomor_antrian'     =>  ($nomor + 1),
                'status_pemeriksaan' => 'Proses Pemeriksaan',
                'dokter_id'         => $request->user_id,
                'tindakan_id'       => $request->jenis_pemeriksaan_laboratorium_id,
                ];
                NomorAntrian::create($nomorAntrianData);
                $pendaftaran->save();
    }

    public function destroy($id)
    {

        $data = NomorAntrian::findOrFail($id);
        $data->delete();
    }

    public function show($id)
    {
        $data['rujukanInternal'] = RujukanInternal::with('dokter', 'poliklinik', 'tindakan')
                                    ->where('pendaftaran_id', $id);
                                    //->where('poliklinik_id',\Auth::user()->poliklinik_id);
        $data['nomorAntrian'] = NomorAntrian::with('poliklinik', 'dokter', 'tindakan')
                                ->where('poliklinik_id', '!=', \Auth::user()->poliklinik_id)
                                ->where('pendaftaran_id', $id);
        return view('pendaftaran.partials.rujukan_internal', $data);
    }
}
