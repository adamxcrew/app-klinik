<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RujukanInternal;
use App\Models\Pendaftaran;
use DataTables;

class PendaftaranRujukanLabController extends Controller
{
    public function store(Request $request)
    {
        $pendaftaran                = Pendaftaran::find($request->pendaftaran_id);
        $request['users_id']        = $request->user_id;
        $request['pasien_id']       = $pendaftaran->pasien_id;
        $request['tindakan_id']     = $request->jenis_pemeriksaan_laboratorium_id;
        RujukanInternal::create($request->all());
        $pendaftaran->status_pelayanan = "pemeriksaan_laboratorium";
        $pendaftaran->save();
    }

    public function delete($id)
    {

        $data = RujukanInternal::findOrFail($id);
        $data->delete();
    }

    public function show(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(RujukanInternal::with(['tindakan'])->where('pasien_id', $request->id)->get())
                ->editColumn('tindakan', function ($row) {
                    return $row->tindakan->nama_jenis;
                })
                ->editColumn('dokter', function ($row) {
                    return $row->dokter->name;
                })
                ->addColumn('action', function ($row) {
                    $btn = "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' onClick='removeRujukan(this)'>Hapus</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
