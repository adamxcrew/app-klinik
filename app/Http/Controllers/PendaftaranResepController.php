<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranResume;
use DataTables;
use App\Models\Obat;

class PendaftaranResepController extends Controller
{
    public function resumeResep(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'obat')->with('obat')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'resume/resep/' . $row->id, 'method' => 'DELETE']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumePilihResep(Request $request)
    {
        $data = Obat::where('id', $request->id)->first();
        return $data;
    }

    public function resumeTambahResep(Request $request)
    {
        $data = PendaftaranResume::create($request->all());
        return $data;
    }

    public function resumeHapusResep($id)
    {
        $data = PendaftaranResume::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }
}
