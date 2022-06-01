<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\PendaftaranDiagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\Poliklinik;
use App\Models\Pasien;
use App\Models\Satuan;
use App\Models\PendaftaranObatRacik;
use App\Models\PendaftaranObatRacikDetail;
use App\Models\JenisPemeriksaanLab;
use App\Models\HasilPemeriksaanLab;
use App\Models\IndikatorPemeriksaanLab;
use App\Models\RiwayatPenyakit;
use App\Models\Barang;
use App\Models\PendaftaranResep;
use App\Models\RujukanInternal;
use DataTables;
use PDF;
use DB;
use Carbon\Carbon;
use App\Http\Requests\PendaftaranInputTandaVitalRequest;
use App\Http\Requests\PendaftaranStoreRequest;
use App\Imports\PendaftaranImport;
use App\Models\PerusahaanAsuransi;
use App\Models\Pegawai;
use App\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PendaftaranTindakan;
use App\Models\NomorAntrian;

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

        $pendaftaran = Pendaftaran::select('pendaftaran.*', 'nomor_antrian.nomor_antrian', 'poliklinik.nama as nama_poliklinik')
        ->with('pasien', 'perusahaanAsuransi')
        ->join('nomor_antrian', 'nomor_antrian.pendaftaran_id', 'pendaftaran.id')
        ->join('poliklinik', 'nomor_antrian.poliklinik_id', 'poliklinik.id')
            ->whereBetween(DB::raw('DATE(pendaftaran.created_at)'), [$awal, $akhir]);

        if (auth()->user()->role == 'poliklinik') {
            $pendaftaran->where('nomor_antrian.poliklinik_id', auth()->user()->poliklinik_id);
            $pendaftaran->where('status_pelayanan', 'selesai_pemeriksaan_medis');
        }

        if (auth()->user()->role == 'kasir') {
            $pendaftaran->where('status_pelayanan', 'selesai_pelayanan');
        }

        if (auth()->user()->role == 'laboratorium') {
            $pendaftaran->where('status_pelayanan', 'pemeriksaan_laboratorium');
        }

        if (auth()->user()->role == 'bagian_pendaftaran') {
            //$pendaftaran->where('status_pelayanan', 'pendaftaran');
        }

        // filter berdasarkan poliklinik
        if ($request->poliklinik_id != null) {
            $pendaftaran->where('nomor_antrian.poliklinik_id', $request->poliklinik_id);
        }

        if ($request->ajax()) {
            $status_pelayanan = $this->status_pelayanan;
            return DataTables::of($pendaftaran->orderBy('id', 'DESC')->get())
                ->addColumn('nomor_antrian_waktu', function ($row) {
                    return tgl_indo(substr($row->created_at, 0, 10)) . '' . substr($row->created_at, 10, 6) . ' / Nomor ' . $row->nomor_antrian;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<button type="button" class="btn btn-danger">Pilih Tindakan</button>
                               <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                               <span class="caret"></span>
                               <span class="sr-only">Toggle Dropdown</span>
                             </button>';
                    $btn .= '<ul class="dropdown-menu" role="menu">';
                    if ($row->status_pelayanan == 'pendaftaran') {
                        $btn .= \Form::open(['url' => 'pendaftaran/' . $row->id, 'method' => 'DELETE', 'style' => 'margin-left:15px']);
                        $btn .= "<li><button type='submit' style='border: 0;background:#fff'><i class='fa fa-times'></i> <span style='margin-left:10px'>Batal</span></button></li>";
                        $btn .= \Form::close();
                    }
                    if (auth()->user()->role == 'poliklinik') {
                        if ($row->status_pelayanan == 'selesai_pemeriksaan_medis') {
                            // cek kalau unit lab maka tampilkan pemeriksaan lab
                            $unit = Poliklinik::where('id', \Auth::user()->poliklinik_id)->first();
                            if ($unit->jenis_unit == 'laboratorium') {
                                $btn .= '<li><a href="/pendaftaran/' . $row->id . '/input-indikator"><i class="fa fa-plus-square"></i> Input Tindakan Lab</a></li>';
                            } elseif (in_array($unit->id, [2,5,3])) {
                                // 2 itu adalah id poli gigi
                                $btn .= '<li><a href="/pendaftaran/' . $row->id . '/pemeriksaan"><i class="fa fa-edit"></i> Input tindakan</a></li>';
                            } else {
                                $btn .= '<li><a href="/ondotogram/' . $row->id . '"><i class="fa fa-plus-square"></i> Pemeriksaan Gigi</a></li>';
                            }
                        } else {
                            $btn .= '<li><a href="/pendaftaran/' . $row->id . '/input_tanda_vital"><i class="fa fa-print"></i> Input Tanda Vital</a></li>';
                        }
                    } elseif (auth()->user()->role == 'apoteker') {
                        $btn .= '<li><a href="/pendaftaran/' . $row->id . '/cetak_label"><i class="fa fa-plus-square"></i> Cetak Label</a></li>';
                    } elseif (auth()->user()->role == 'kasir') {
                        if ($row->status_pembayaran == 1) {
                            $btn = '<a class="btn btn-danger btn-sm btn-block" target="new" href="/pembayaran/' . $row->id . '/kwitansi"><i class="fa fa-print"></i> Kwitansi</a></div>';
                        } else {
                            $btn = '<a class="btn btn-danger btn-sm" style="margin-right:5px" href="/pembayaran/' . $row->id . '"><i class="fa fa-money"></i> Pembayaran</a></div>';
                            $btn .= '<a class="btn btn-danger btn-sm" href="/pembayaran/' . $row->id . '/kwitansi"><i class="fa fa-print"></i> Kwitansi</a></div>';
                        }
                    } elseif (auth()->user()->role == 'laboratorium') {
                        $btn = '<li><a class="btn btn-danger btn-sm" href="/pendaftaran/' . $row->id . '/input-indikator"><i class="fa fa-edit"></i> Input Indikator</a></li>';
                    } elseif (auth()->user()->role == 'admin_medis') {
                        if ($row->status_pelayanan == 'pendaftaran') {
                            $btn .= '<li><a href="/pendaftaran/' . $row->id . '/input_tanda_vital"><i class="fa fa-print"></i> Input Tanda Vital</a></li>';
                        }
                    } else {
                        if ($row->status_pelayanan == 'batal') {
                            $btn .= "<li><button type='button' class='btn btn-default btn-sm'>Dibatalkan</button></li>";
                        } else {
                            $btn .= '<li><a href="/pendaftaran/' . $row->id . '/cetak"><i class="fa fa-print"></i> Cetak Antrian</a></li>';
                            $btn .= '<li><a href="/pendaftaran/' . $row->id . '/edit"><i class="fa fa-edit"></i> Edit</a></li>';
                        }
                    }
                    $btn .= '</ul>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('jenis_layanan', function ($row) {
                    if (isset($row->perusahaanAsuransi)) {
                        return $row->perusahaanAsuransi->nama_perusahaan;
                    }
                    return "Tidak ada";
                })
                ->addColumn('nama', function ($row) {
                    return $row->pasien->inisial . ' . ' . $row->pasien->nama;
                })
                ->addColumn('status_pelayanan', function ($row) use ($status_pelayanan) {
                    return $status_pelayanan[$row->status_pelayanan];
                })
                ->addColumn('nomor_rekam_medis', function ($row) {
                    $checked = $row->check_list_poli_kebidanan == 1 ? 'checked' : '';
                    $checkbox = \Auth::user()->poliklinik_id == 3 ? '<input ' . $checked . ' onclick="checklist(' . $row->id . ')" type="checkbox"> ' : '';
                    return $checkbox . '' . $row->pasien->nomor_rekam_medis;
                })
                ->rawColumns(['action','nomor_rekam_medis'])
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
        $data['tidakanLab'] = Tindakan::where('jenis', 'tindakan_laboratorium')->pluck('tindakan', 'id');
        return view('pendaftaran.pasien-terdaftar', $data);
    }

    public function input_indikator($id)
    {
        //$data['pendaftaran']            = NomorAntrian::with('pendaftaran')->where('pendaftaran_id',$id)->where('poliklinik_id',\Auth::user()->poliklinik_id)->first();
        $data['pendaftaran']            = Pendaftaran::with('pasien')->find($id);
        $nomorAntrian                   = NomorAntrian::where('pendaftaran_id', $id)->where('poliklinik_id', \Auth::user()->poliklinik_id)->first();
        $data['tindakan']               = Tindakan::where('id', $nomorAntrian->tindakan_id)->first();
        $data['hasilPemeriksaan']       = HasilPemeriksaanLab::where('pendaftaran_id', $id)->get();
        $data['indikatorPemeriksaan']   = IndikatorPemeriksaanLab::where('tindakan_id', $nomorAntrian->tindakan_id)->get();
        return view('pendaftaran.indikator', $data);
    }

    public function simpanHasilPemeriksaanLab($pendaftaranId, Request $request)
    {
        $jmlIndikator = count($request->indikator_id) - 1;
        for ($i = 0; $i <= $jmlIndikator; $i++) {
            // jadikan inserOrUpdate
            \DB::table('pendaftaran_hasil_pemeriksaan_lab')->insert([
                'indikator_pemeriksaan_lab_id'  =>  $request->indikator_id[$i],
                'catatan'       =>  $request->catatan[$i],
                'hasil'         =>  $request->hasil[$i],
                'pendaftaran_id' => $pendaftaranId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \DB::table('nomor_antrian')
            ->where('pendaftaran_id', $pendaftaranId)
            ->where('poliklinik_id', \Auth::user()->poliklinik_id)
            ->update(['status_pemeriksaan' => 'Selesai']);
        }

        RujukanInternal::where('pendaftaran_id', $pendaftaranId)->update(['status' => 'Selesai']);
        return redirect('pendaftaran/' . $pendaftaranId . '/input-indikator')->with('message', 'Data Berhasil Disimpan');
    }

    public function printHasilPemeriksaan($id)
    {
        $listIndikator = HasilPemeriksaanLab::where('pendaftaran_id', $id)->get();

        $data['pendaftaran'] = NomorAntrian::where('pendaftaran_id', $id)
        ->where('poliklinik_id', \Auth::user()->poliklinik_id)
        ->with('poliklinik', 'dokter')
        ->first();
        // $data['jenisPemeriksaan'] = JenisPemeriksaanLab::findOrFail($id);

        $data['indikatorPemeriksaan'] = IndikatorPemeriksaanLab::all();
        $data['listIndikator'] = $listIndikator;
        $data['carbon'] = new Carbon();
        // return view('pendaftaran.pdf_hasil_pemeriksaan_lab',$data);
        $pdf = PDF::loadView('pendaftaran.pdf_hasil_pemeriksaan_lab', $data)->setPaper('letter', 'potrait');
        return $pdf->stream();
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
                'status_alergi_value',
                'lingkar_perut',
                'djj',
                'tfu',
                'imt'
            )),
            'pemeriksaan_klinis'    =>  serialize($request->pemeriksaan_klinis),
            'status_pelayanan'      =>  'selesai_pemeriksaan_medis',
            'status_alergi'         => $request->status_alergi_value,
            'anamnesa'              => $request->anamnesa,
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
        $request['dokter_id'] = $request->dokter_id == 0 ? $request->dokter_pengganti : $request->dokter_id;
        $data = Pendaftaran::create($request->all());
        // create nomor antrian
        $nomor = NomorAntrian::where('poliklinik_id', $request->poliklinik_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->max('nomor_antrian');
        $nomorAntrianData = [
            'pendaftaran_id'    =>  $data->id,
            'poliklinik_id'     =>  $request->poliklinik_id,
            'dokter_id'         => $request['dokter_id'],
            'nomor_antrian'     =>  ($nomor + 1)
        ];
        NomorAntrian::create($nomorAntrianData);
        return redirect('/pendaftaran/' . $data->id . '/cetak');
    }

    public function edit($id)
    {
        $data['pendaftaran']         = Pendaftaran::with('pasien')->findOrFail($id);
        $data['perusahaan_asuransi'] = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['dokter'] = User::where('role', 'dokter')->pluck('name', 'id');

        return view('pendaftaran.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::with('pasien')->findOrFail($id);
        $pendaftaran->update($request->all());
        $nomor = NomorAntrian::where('poliklinik_id', $request->poliklinik_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->max('nomor_antrian');
        $antrian = NomorAntrian::where('pendaftaran_id', $id)->first();
        $antrian->update(['dokter_id' => $request->dokter_id,'nomor_antrian' => ($nomor + 1),'poliklinik_id' => $request->poliklinik_id]);

        return redirect('/pendaftaran/' . $id . '/cetak');
        //return redirect(route('pendaftaran.index'))->with('message', 'Data Pendaftaran Pasien Bernama ' . ucfirst($pendaftaran->pasien->nama) . ' Berhasil Di Update');
    }

    public function cetak($id)
    {
        $data['pasien'] = Pendaftaran::find($id);
        $data['antrian'] = NomorAntrian::with('poliklinik', 'dokter')->where('pendaftaran_id', $id)->orderBy('id', 'DESC')->first();

        return view('pendaftaran.nomor-antrian', $data);
    }

    public function print($id)
    {
        $data['pasiens'] = Pendaftaran::where('pendaftaran.id', $id)
        ->with('dokter')
        ->leftJoin('nomor_antrian', 'nomor_antrian.pendaftaran_id', 'pendaftaran.id')
        ->get();
        $pdf = PDF::loadView('pendaftaran.cetak', $data);
        return $pdf->stream();
    }

    public function destroy($id)
    {
        Pendaftaran::where('id', $id)->update(['status_pelayanan' => 'batal']);
        return redirect('/pendaftaran');
    }

    public function pemeriksaanRiwayatPenyakit(Request $request, $id)
    {
        $request['pendaftaran_id'] = $id;
        $pendaftaran = Pendaftaran::findOrFail($id);
        $request['pasien_id'] = $pendaftaran->pasien_id;
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
            $pendaftaran = Pendaftaran::with('pasien.riwayatPenyakit')->findOrFail($request->id);
            return DataTables::of($pendaftaran->pasien->riwayatPenyakit)
                ->editColumn('kode', function ($row) {
                    return $row->tbmIcd->kode;
                })
                ->editColumn('tbm_icd', function ($row) {
                    return $row->tbmIcd->indonesia;
                })
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

    public function riwayatRawatJalan(Request $request)
    {
        $riwayatRawatJalan = Pendaftaran::with(['poliklinik', 'dokter', 'perusahaanAsuransi'])->where('id', $request->id)->get();

        if ($request->ajax()) {
            return DataTables::of($riwayatRawatJalan)
                ->addColumn('created_at', function ($row) {
                    return substr($row->created_at, 0, 10);
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function import_excel(Request $request)
    {
        // menangkap file excel
        $file = $request->file('import_file');

        // membuat nama file unik
        $nama_file = $file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file-excel', $nama_file);

        // import data
        try {
            Excel::import(new PendaftaranImport(), public_path('/file-excel/' . $nama_file));
            return redirect('/pendaftaran')->with('message', 'Data calon pasien berhasil diimport!');
        } catch (\Throwable $th) {
            return redirect(route('pendaftaran.index'))->with('message', 'File excel tidak valid!');
        }
    }

    public function pemeriksaan($id)
    {
        $data['pendaftaran']            = Pendaftaran::with('pasien', 'jenisLayanan')->find($id);
        $data['dokter1']                = User::where('role', 'dokter')->pluck('name', 'id');
        $data['satuan']                 = Satuan::pluck('satuan', 'id');
        $data['poliklinik1']            = Poliklinik::pluck('nama', 'id');
        $data['pendaftaranResepRacik']  = PendaftaranObatRacik::where('pendaftaran_id', $id);
        $data['jenisPemeriksaanLaboratorium'] = Tindakan::pluck('tindakan', 'id');
        // $data['riwayatKunjungan']   = Pendaftaran::with('nomorAntrian', 'perusahaanAsuransi')
        //     ->where('pasien_id', $data['pendaftaran']->pasien->id)
        //     //->where('id', '!=', $id)
        //     ->get();
        $data['riwayatKunjungan'] =     \DB::select("select na.id,
                                        p.kode,
                                        pa.nomor_rekam_medis,
                                        pa.nama as nama_pasien,
                                        cast(p.created_at as Date) as tanggal_kunjungan,
                                        po.nama as poliklinik,
                                        pas.nama_perusahaan as perusahaan_penjamin
                                        from nomor_antrian as na
                                        join pendaftaran as p on p.id=na.pendaftaran_id
                                        join pasien as pa on pa.id=p.pasien_id
                                        join poliklinik as po on po.id=na.poliklinik_id
                                        join perusahaan_asuransi as pas on pas.id=p.jenis_layanan");
        $data['barang'] = Barang::pluck('nama_barang', 'id');
        //return $data['riwayatKunjungan'] ;
        return view('pendaftaran.pemeriksaan', $data);
    }

    public function cetakRekamedis($id)
    {
        $data['pendaftaran']        = Pendaftaran::with('pasien', 'jenisLayanan')->find($id);
        $data['riwayatKunjungan']   = Pendaftaran::with('poliklinik', 'dokter', 'perusahaanAsuransi')
        ->where('pasien_id', $data['pendaftaran']->pasien->id)
        ->get();
       // return view('pendaftaran.cetak_rekamedis', $data);
        $pdf = PDF::loadView('pendaftaran.cetak_rekamedis', $data);
        return $pdf->stream();
    }


    public function logRiwayatIterasi($id)
    {
        $data['riwayat'] = \App\Models\RiwayatPenggunaanTindakanIterasi::all();
        return view('pasien.log_riwayat_iterasi', $data);
    }

    public function logRiwayatKunjungan($id)
    {
        $data['pendaftaran']    = NomorAntrian::with('pendaftaran')->findOrFail($id);
        $data['tindakan']       = PendaftaranTindakan::with('tindakan')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id)
                                ->get();
        $data['diagnosa']       = PendaftaranDiagnosa::with('icd')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id)
                                ->get();

        $data['obatNonRacik']   = PendaftaranResep::with('barang')
                                ->where('pendaftaran_id', $data['pendaftaran']->pendaftaran_id)
                                ->get();
        return view('pasien.riwayat_kunjungan_detail', $data);
    }
}
