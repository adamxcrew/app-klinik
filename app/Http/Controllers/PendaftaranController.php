<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Diagnosa;
use App\Models\PendaftaranDiagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poliklinik;
use App\Models\Pasien;
use App\Models\RiwayatPenyakit;
use App\Models\PendaftaranResume;
use DataTables;
use PDF;
use DB;
use App\Http\Requests\PendaftaranInputTandaVitalRequest;
use App\Http\Requests\PendaftaranStoreRequest;
use App\Models\PerusahaanAsuransi;
use App\Models\Pegawai;

class PendaftaranController extends Controller
{
    protected $penjamin;
    protected $hubungan_pasien;
    protected $jenis_pendaftaran;
    protected $jenis_rujukan;
    protected $status_pelayanan;

    public function __construct()
    {
        $this->hubungan_pasien   = config('datareferensi.hubungan_pasien');
        $this->jenis_pendaftaran = config('datareferensi.jenis_pendaftaran');
        $this->jenis_rujukan     = config('datareferensi.jenis_rujukan');
        $this->inisial           = config('datareferensi.inisial');
        $this->status_pelayanan  = config('datareferensi.status_pelayanan');
    }

    public function index(Request $request)
    {
        $data['tanggal_awal']   = $request->tanggal_awal ?? date('Y-m-d');
        $data['tanggal_akhir']  = $request->tanggal_akhir ?? date('Y-m-d');
        $data['poliklinik_id']  = $request->poliklinik_id;

        $awal = date('Y-m-d H:i:s', strtotime($data['tanggal_awal']));
        $akhir = date('Y-m-d H:i:s', strtotime($data['tanggal_akhir']));

        $pendaftaran = Pendaftaran::with('pasien', 'perusahaanAsuransi')
            ->with('poliklinik')
            ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$awal, $akhir]);

        if (auth()->user()->role == 'poliklinik') {
            $pendaftaran->where('status_pelayanan', 'selesai_pemeriksaan_medis');
        }

        if (auth()->user()->role == 'kasir') {
            $pendaftaran->where('status_pelayanan', 'selesai_pelayanan');
        }

        // filter berdasarkan poliklinik
        if ($request->poliklinik_id != null) {
            $pendaftaran->where('poliklinik_id', $request->poliklinik_id);
        }

        if ($request->ajax()) {
            $status_pelayanan = $this->status_pelayanan;
            return DataTables::of($pendaftaran->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-times'></i> Batal</button>";
                    $btn .= \Form::close();
                    if (auth()->user()->role == 'admin_medis') {
                        $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/input_tanda_vital"><i class="fa fa-print"></i> Input Tanda Vital</a> ';
                    } elseif (auth()->user()->role == 'poliklinik') {
                        if ($row->status_pelayanan == 'selesai_pemeriksaan_medis') {
                            $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/pemeriksaan/tindakan"><i class="fa fa-edit"></i> Input tindakan</a> ';
                        }
                    } elseif (auth()->user()->role == 'kasir') {
                        $btn = '<a class="btn btn-danger btn-sm" href="/pembayaran/' . $row->id . '"><i class="fa fa-money"></i> Pembayaran</a> ';
                    } else {
                        $btn .= '<a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/cetak"><i class="fa fa-print"></i> Cetak Antrian</a> ';
                    }
                    return $btn;
                })
                ->addColumn('jenis_layanan', function ($row) {
                    return $row->perusahaanAsuransi->nama_perusahaan;
                })
                ->addColumn('status_pelayanan', function ($row) use ($status_pelayanan) {
                    return $status_pelayanan[$row->status_pelayanan];
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
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        $data['jenis_rujukan']     = $this->jenis_rujukan;
        $data['hubungan_pasien']   = $this->hubungan_pasien;
        $data['jenis_pendaftaran'] = $this->jenis_pendaftaran;

        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['daftar_pasien'] = Pasien::pluck('nama', 'id');
        $data['pasien_id'] = $pasien_id;
        return view('pendaftaran.pasien-terdaftar', $data);
    }

    public function pemeriksaan(Request $request, $id)
    {
        $jenis          = $request->segment(4);
        $data['pendaftaran']   = Pendaftaran::with('pasien', 'perusahaanAsuransi')->find($id);
        if ($jenis == 'tindakan') {
            $data['tindakan'] = Tindakan::all();
            $data['diagnosa'] = Diagnosa::all();
            $data['obat']     = Obat::all();
            $data['dokter']   = Pegawai::pluck('nama', 'id');
            return view('pendaftaran.pemeriksaan_tindakan', $data);
        }

        return view('pendaftaran.pemeriksaan_' . $jenis, $data);
    }



    public function input_tanda_vital($id)
    {
        $data['pendaftaran'] = Pendaftaran::with('pasien')->find($id);
        return view('pendaftaran.input_tanda_vital', $data);
    }

    public function input_tanda_vital_store($id, PendaftaranInputTandaVitalRequest $request)
    {
        $pendaftaran    = Pendaftaran::find($id);
        $input          = $request->except(['_token', '_method']);
        $data           = [
            'tanda_tanda_vital'     => serialize($request->only(
                'berat_badan',
                'tekanan_darah',
                'jenis_kasus',
                'suhu_tubuh',
                'tinggi_badan',
                'nadi',
                'rr',
                'saturasi_o2',
                'fungsi_penciuman',
                'status_alergi'
            )),
            'pemeriksaan_klinis'    =>  serialize($request->pemeriksaan_klinis),
            'status_pelayanan'      =>  'selesai_pemeriksaan_medis'
        ];
        $pendaftaran->update($data);
        return redirect('pendaftaran/')->with('message', 'Tanda Tanda Vital Berhasil Disimpan');
    }

    public function detailPasien(Request $request)
    {
        $pendaftaran = Pendaftaran::find($id);
        $data = Pasien::where('id', $request->id)->first();
        return $data;
    }

    public function store(PendaftaranStoreRequest $request)
    {
        $request['dokter_id'] = $request->dokter_id==0?$request->dokter_pengganti:$request->dokter_id;
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
        $data['pasien'] = Pendaftaran::where('id', $id)->with('dokter')->first();
        $pdf = PDF::loadView('pendaftaran.cetak', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        Pendaftaran::where('id', $id)->update(['status_pelayanan' => 'batal']);
        return redirect('/pendaftaran');
    }

    public function addItem(Request $request, $id)
    {
        if (isset($request->item[0])) {
            foreach ($request->item as $jenis_resume_id) {
                $data['jenis_resume_id'] = $jenis_resume_id;
                $data['pendaftaran_id'] = $id;
                $data['jenis'] = $request->jenis;
                PendaftaranResume::create($data);
            }
        }
        return view('pendaftaran.ajax-table-' . $request->jenis);
    }

    public function pemeriksaanRiwayatPenyakit(Request $request, $id)
    {
        $request['pendaftaran_id'] = $id;
        RiwayatPenyakit::create($request->all());
        return view('pendaftaran.ajax-table-riwayat-penyakit');
    }

    public function pemeriksaanRiwayatPenyakitHapus($id)
    {
        $data = RiwayatPenyakit::findOrFail($id);
        $data->delete();

        return view('pendaftaran.ajax-table-riwayat-penyakit');
    }

    public function resumeRiwayatPenyakit(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(RiwayatPenyakit::where('pendaftaran_id', $request->id)->get())
                ->addColumn('action', function ($row) {
                    $btn = "<div class='btn btn-danger btn-sm' data-id = '" . $row->id . "' onClick='removeRiwayatPenyakit(this)'>Hapus</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function selesai($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status_pelayanan' => 'selesai_pelayanan']);
        return redirect('/pendaftaran')->with('message', 'Selesai Melakukan Pelayanan');
    }
}
