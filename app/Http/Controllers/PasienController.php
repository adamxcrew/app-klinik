<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Pasien;
use App\Http\Requests\PasienStoreRequest;
use App\Models\Poliklinik;
use App\Models\Pendaftaran;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Diagnosa;
use App\Models\Tindakan;
use App\Models\Obat;
use App\Models\PendaftaranDiagnosa;
use App\Models\PendaftaranResep;
use App\Models\PendaftaranTindakan;
use App\Models\PerusahaanAsuransi;
use PDF;

class PasienController extends Controller
{
    protected $agama;
    protected $jenjang_pendidikan;
    protected $status_pernikahan;
    protected $kewarganegaraan;
    protected $golongan_darah;
    protected $privilage_khusus;
    protected $hubungan_pasien;
    protected $penjamin;
    protected $inisial;

    public function __construct()
    {
        $this->agama              = config('datareferensi.agama');
        $this->jenisIdentitas     = config('datareferensi.jenis_identitas');
        $this->jenjang_pendidikan = config('datareferensi.jenjang_pendidikan');
        $this->status_pernikahan  = config('datareferensi.status_pernikahan');
        $this->kewarganegaraan    = config('datareferensi.kewarganegaraan');
        $this->golongan_darah     = config('datareferensi.golongan_darah');
        $this->privilage_khusus   = config('datareferensi.privilage_khusus');
        $this->hubungan_pasien    = config('datareferensi.hubungan_pasien');
        $this->penjamin           = config('datareferensi.penjamin');
        $this->inisial            = config('datareferensi.inisial');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Pasien::all())
                ->addColumn('tempat_tanggal_lahir', function ($row) {
                    return $row->tempat_lahir . ', ' . tgl_indo($row->tanggal_lahir);
                })
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'pasien/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    // $btn .= '<a class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '/diagnosa"><i class="fa fa-user" aria-hidden="true"></i></a>';
                    // $btn .= '<a title="Pendaftaran Baru" class="btn btn-danger btn-sm" href="/pasien/' . $row->id . '"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }

        $data['pendaftaran'] = Pendaftaran::with(['poliklinik', 'dokter', 'perusahaanAsuransi'])->get();

        return view('pasien.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['inisial']            = $this->inisial;
        $data['jenisIdentitas']     = $this->jenisIdentitas;
        $data['agama']              = $this->agama;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        $data['status_pernikahan']  = $this->status_pernikahan;
        $data['kewarganegaraan']    = $this->kewarganegaraan;
        $data['golongan_darah']     = $this->golongan_darah;
        $data['privilage_khusus']   = $this->privilage_khusus;
        $data['hubungan_pasien']    = $this->hubungan_pasien;
        $data['penjamin']           = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');
        $data['poliklinik']         = Poliklinik::pluck('nama', 'id');
        return view('pasien.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PasienStoreRequest $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = str_replace(' ', '', $file->getClientOriginalName());
            $path = $file->storeAs('public/pasien', $fileName);
            $data['foto']        = $fileName;
        }

        $wilayah_administratif = \DB::table('view_wilayah_administratif_indonesia')
            ->where('village_id', $request->wilayah_administratif)
            ->first();
        $data                = $request->all();

        $data['village_id']  = $wilayah_administratif->village_id;
        $data['district_id'] = $wilayah_administratif->district_id;
        $data['province_id'] = $wilayah_administratif->province_id;
        $data['regency_id']  = $wilayah_administratif->regency_id;
        $pasien              = Pasien::create($data);
        $data['pasien_id']   = $pasien->id;
        return redirect('pendaftaran/create/' . $pasien->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['agama']              = $this->agama;
        $data['inisial']            = $this->inisial;
        $data['jenisIdentitas']     = $this->jenisIdentitas;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        $data['status_pernikahan']  = $this->status_pernikahan;
        $data['kewarganegaraan']    = $this->kewarganegaraan;
        $data['golongan_darah']     = $this->golongan_darah;
        $data['privilage_khusus']   = $this->privilage_khusus;
        $data['hubungan_pasien']    = $this->hubungan_pasien;
        $data['penjamin']           = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');

        $data['pasien'] = Pasien::findOrFail($id);
        $data['poliklinik'] = Poliklinik::pluck('nama', 'id');
        $data['provinces'] = Province::pluck('name', 'id');
        return view('pasien.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['agama']              = $this->agama;
        $data['inisial']            = $this->inisial;
        $data['jenisIdentitas']     = $this->jenisIdentitas;
        $data['jenjang_pendidikan'] = $this->jenjang_pendidikan;
        $data['status_pernikahan']  = $this->status_pernikahan;
        $data['kewarganegaraan']    = $this->kewarganegaraan;
        $data['golongan_darah']     = $this->golongan_darah;
        $data['privilage_khusus']   = $this->privilage_khusus;
        $data['hubungan_pasien']    = $this->hubungan_pasien;
        $data['penjamin']           = PerusahaanAsuransi::pluck('nama_perusahaan', 'id');

        $data['pasien'] = Pasien::with('wilayahAdministratifIndonesia')->findOrFail($id);
        return view('pasien.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());
        return redirect(route('pasien.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        return redirect(route('pasien.index'))->with('message', 'Data Berhasil Dihapus');
    }


    public function riwayatKunjungan($idPendaftaran)
    {
        $tindakan       = PendaftaranTindakan::with('tindakan.icd')->where('pendaftaran_id', $idPendaftaran)->get();
        $diagnosa       = PendaftaranDiagnosa::with('icd')->where('pendaftaran_id', $idPendaftaran)->get();
        $obat           = PendaftaranResep::with('barang')->where('pendaftaran_id', $idPendaftaran)->get();
        //$pendaftaran    = Pendaftaran::with('nomorAntrian.poliklinik','pasien', 'poliklinik', 'dokter')->find($idPendaftaran);

        $pendaftaran    = Pendaftaran::with(['nomorAntrian' => function ($antrian) {
            $antrian->with(['poliklinik', 'dokter'])->get();
        }])->find($idPendaftaran);

        $riwayatKunjungan = [
            "pasien"   => $pendaftaran->pasien->nama,
            "tindakan" => $tindakan,
            "diagnosa" => $diagnosa,
            'pendaftaran' => $pendaftaran,
            "obat"     => $obat,
            "tanggal_pelayanan" => tgl_indo(substr($pendaftaran->created_at, 0, 10))
        ];

        return $riwayatKunjungan;
    }
}
