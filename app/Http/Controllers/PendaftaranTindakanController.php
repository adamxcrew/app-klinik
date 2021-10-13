<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\PendaftaranResume;

class PendaftaranTindakanController extends Controller
{
    public function resumeTindakan(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'tindakan')->with('tindakan')->get())
                ->addColumn('action', function ($row) {
                    $btn = "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' data-jenis='tindakan' onClick='removeItem(this)'>Hapus</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumePilihTindakan(Request $request)
    {
        $data = PendaftaranResume::create($request->all());
        return $data;
    }

    public function resumeHapusTindakan($id)
    {
        $data = PendaftaranResume::findOrFail($id);
        $data->delete();

        return view('pendaftaran.ajax-table-tindakan');
    }
}
