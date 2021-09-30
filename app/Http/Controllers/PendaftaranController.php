<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poliklinik;
use App\Models\Pasien;
use App\Models\PendaftaranResume;
use DataTables;
use PDF;
use DB;
use App\Http\Requests\PendaftaranInputTandaVitalRequet;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['poliklinik_id']  = $request->poliklinik_id;
        
        $pendaftaran = Pendaftaran::with('pasien')
                    ->with('poliklinik')
                    ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$data['tanggal_awal'],$data['tanggal_akhir']]);
        
        // filter berdasarkan poliklinik
        if ($request->poliklinik_id!=null) {
            $pendaftaran->where('poliklinik_id', $request->poliklinik_id);
        }
        if ($request->ajax()) {
            return DataTables::of($pendaftaran->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:15px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '">Detail</a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/input_tanda_vital">Input Tanda Vital</a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        return view('pendaftaran.index', $data);
    }

    public function create($pasien_id = null)
    {
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['daftar_pasien'] = Pasien::pluck('nama', 'id');
        $data['pasien_id'] = $pasien_id;
        return view('pendaftaran.pasien-terdaftar', $data);
    }


    public function input_tanda_vital($id)
    {
        $data['pendaftaran'] = Pendaftaran::with('pasien')->find($id);
        return view('pendaftaran.input_tanda_vital', $data);
    }

    public function input_tanda_vital_store($id, PendaftaranInputTandaVitalRequet $request)
    {
        $pendaftaran    = Pendaftaran::find($id);
        $input          = $request->except(['_token', '_method']);
        $pendaftaran->update(['tanda_tanda_vital' => serialize($input)]);
        return redirect('pendaftaran/' . $id)->with('message', 'Tanda Tanda Fital Berhasil Disimpan');
    }

    public function detailPasien(Request $request)
    {
        $pendaftaran = Pendaftaran::find($id);
        $data = Pasien::where('id', $request->id)->first();
        return $data;
    }

    public function store(Request $request)
    {
        $data = Pendaftaran::create($request->all());
        return redirect('/pendaftaran/' . $data->id . '/cetak');
    }

    public function show($id)
    {
        $data['diagnosa'] = Diagnosa::all();
        $data['obat']     = Obat::all();
        $data['tindakan'] = Tindakan::all();
        $data['pasien']   = Pendaftaran::find($id);
        return view('pendaftaran.detail', $data);
    }

    public function cetak($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        return view('pendaftaran.nomor-antrian', $data);
    }

    public function print($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        $pdf = PDF::loadView('pendaftaran.cetak', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        $data = Pendaftaran::findOrFail($id);
        $data->delete();

        return redirect('/pendaftaran');
    }

    public function resumeDiagnosa(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'diagnosa')->with('diagnosa')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'resume/diagnosa/' . $row->id, 'method' => 'DELETE']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function resumePilihDiagnosa(Request $request)
    {
        $data = PendaftaranResume::create($request->all());
        return $data;
    }

    public function resumeHapusDiagnosa($id)
    {
        $data = PendaftaranResume::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }

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

    public function resumeTindakan(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendaftaranResume::where('jenis', 'tindakan')->with('tindakan')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'resume/tindakan/' . $row->id, 'method' => 'DELETE']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'>Hapus</button>";
                    $btn .= \Form::close();
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

        return redirect()->back();
    }
}
