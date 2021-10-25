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
            return DataTables::of(RujukanInternal::where('pasien_id', $request->id)->get())
                ->editColumn('tindakan', function ($row) {
                    return $row->tindakan->tindakan;
                })
                ->editColumn('dokter', function ($row) {
                    return $row->dokter->name;
                })
                ->addIndexColumn()
                ->make(true);
        }
    }
}
