<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\PendaftaranTindakan;

class PendaftaranTindakanController extends Controller
{
    public function resumeTindakan(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranTindakan::where('pendaftaran_id', $request->pendaftaran_id)->with('tindakan')->get())
                ->addColumn('action', function ($row) {
                    return "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' data-jenis='tindakan' onClick='removeItem(this)'>Hapus</div>";
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumeTambahTindakan(Request $request)
    {
        PendaftaranTindakan::create($request->all());
        return view('pendaftaran.ajax-table-tindakan');
    }

    public function resumePilihTindakan(Request $request)
    {
        return PendaftaranTindakan::create($request->all());
    }

    public function resumeHapusTindakan($id)
    {
        $data = PendaftaranTindakan::findOrFail($id);
        $data->delete();

        return view('pendaftaran.ajax-table-tindakan');
    }
}
