<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranResep;
use DataTables;
use App\Models\Obat;

class PendaftaranResepController extends Controller
{
    public function dataPemeriksaanResep(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResep::where('pendaftaran_id', $request->id)->where('jenis', $request->jenis)->get())
                ->addColumn('action', function ($row) {
                    $btn = "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' onClick='removeObatRacik(this)'>Hapus</div>";
                    return $btn;
                })
                ->editColumn('kode', function ($row) {
                    return $row->barang->kode;
                })
                ->editColumn('harga', function ($row) {
                    return convert_rupiah($row->harga);
                })
                ->editColumn('nama', function ($row) {
                    return $row->barang->nama_barang;
                })
                ->editColumn('jumlah', function ($row) {
                    return $row->jumlah . ' ' . $row->satuan;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function storePemeriksaanResep(Request $request, $id)
    {
        $request['pendaftaran_id'] = $id;
        PendaftaranResep::create($request->all());
        return view('pendaftaran.ajax-table-obat-racik');
    }

    public function hapusPemeriksaanResep($id)
    {
        $data = PendaftaranResep::findOrFail($id);
        $data->delete();
        return view('pendaftaran.ajax-table-obat-racik');
    }
}
