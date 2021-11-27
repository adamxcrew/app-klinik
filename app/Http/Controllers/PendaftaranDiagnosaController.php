<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosa;
use App\Models\PendaftaranDiagnosa;
use DataTables;

class PendaftaranDiagnosaController extends Controller
{
    public function pemeriksaanDiagnosa(Request $request, $id)
    {
        $request['pendaftaran_id'] = $id;
        PendaftaranDiagnosa::create($request->all());
        return view('pendaftaran.ajax-table-diagnosa');
    }

    public function pemeriksaanDiagnosaHapus($id)
    {

        $data = PendaftaranDiagnosa::findOrFail($id);
        $data->delete();

        return view('pendaftaran.ajax-table-diagnosa');
    }

    public function resumeDiagnosaICD(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranDiagnosa::where('pendaftaran_id', $request->id)->get())
                ->editColumn('kode', function ($row) {
                    return $row->icd->kode;
                })
                ->editColumn('tbm_icd', function ($row) {
                    return $row->icd->indonesia;
                })
                ->addColumn('action', function ($row) {
                    $btn = "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' onClick='removeDiagnosa(this)'>Hapus</div>";
                    return $btn;
                })
                ->editColumn('tbm_icd', function ($row) {
                    return $row->icd->indonesia;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
