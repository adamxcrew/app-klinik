<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RujukanInternal;
use App\Models\Pendaftaran;
use DataTables;

class PendaftaranRujukanLabController extends Controller
{
    public function pemeriksaanRujukanLab(Request $request)
    {
        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);
        RujukanInternal::create($request->all());
        $pendaftaran->status_pelayanan = "pemeriksaan_laboratorium";
        $pendaftaran->save();
        // return redirect('/pendaftaran');
        return view('pendaftaran.ajax-table-rujukan-laboratorium');
    }

    public function pemeriksaanRujukanLabHapus($id)
    {

        $data = RujukanInternal::findOrFail($id);
        $data->delete();

        return view('pendaftaran.ajax-table-rujukan-laboratorium');
    }

    public function resumeRujukanLab(Request $request)
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
