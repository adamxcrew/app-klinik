<?php

namespace App\Http\Controllers;

use Fpdf;
use DataTables;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\GajiDetail;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;
use App\Models\PegawaiTunjanganGaji;
use App\Http\Requests\GajiDetailStoreRequest;

class GajiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['periode'] = $request->periode ?? date('m/Y');
        if ($request->ajax()) {
            $gaji = Gaji::with('pegawai')->where('periode', $data['periode'])->get();
            // kalau data nya belum ada maka buat dulu
            if ($gaji->count() == 0) {
                foreach (Pegawai::all() as $pegawai) {
                    $createGaji = Gaji::create([
                        'pegawai_id'    => $pegawai->id,
                        'periode'       => $data['periode'],
                        'status_bayar'  => 0
                    ]);

                    // insert detail komponen gaji
                    $komponenGajiPegawai = PegawaiTunjanganGaji::where('pegawai_id', $pegawai->id)->get();
                    foreach ($komponenGajiPegawai as $komponen) {
                        GajiDetail::create([
                            'pegawai_id'        =>  $pegawai->id,
                            'komponen_gaji_id'  =>  $komponen->komponen_gaji_id,
                            'jumlah'            =>  $komponen->jumlah,
                            'gaji_id'           =>  $createGaji->id
                        ]);
                    }
                }
            }

            return DataTables::of($gaji)
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-danger btn-sm" href="/gaji/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= '<a class="btn btn-danger btn-sm" href="/gaji/' . $row->id . '/cetak"><i class="fa fa-print" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('gaji.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('akun.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GajiDetailStoreRequest $request)
    {
        $gaji = GajiDetail::create($request->all());
        return redirect('gaji/' . $gaji->gaji_id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(KomponenGaji::all())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'gaji/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= '<a class="btn btn-primary btn-sm" href="/gaji/' . $row->id . '/edit' . $row->role . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('gaji.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $data['gaji'] = Gaji::findOrFail($id);

        if ($request->ajax()) {
            return DataTables::of(GajiDetail::where('gaji_id', $data['gaji']->id)->with(['komponen_gaji', 'gaji'])->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'gaji-detail/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= '<a class="btn btn-primary btn-sm" href="/gaji-detail/' . $row->id . '/edit' . $row->role . '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> ';
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    return $btn;
                })
                ->addColumn('gaji.status_bayar', function ($row) {
                    return $row->gaji->status_bayar == 1 ? 'Sudah Dibayar' : 'Belum Dibayar';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $data['komponen_gaji'] = KomponenGaji::pluck('nama_komponen', 'id');
        $data['pegawai'] = Pegawai::findOrFail($data['gaji']->pegawai_id);
        return view('gaji.edit', $data);
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
        $gajiDetail = GajiDetail::findOrFail($id);
        $gajiDetail->update($request->all());
        return redirect('gaji/' . $gajiDetail->gaji_id . '/edit')->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gajiDetail = GajiDetail::findOrFail($id);
        $gajiDetail->delete();
        return redirect('gaji/' . $gajiDetail->gaji_id . '/edit')->with('message', 'Data Berhasil Dihapus');
    }

    public function editGajiDetail($id)
    {
        $data['gajiDetail'] = GajiDetail::findOrFail($id);
        $data['gaji'] = Gaji::findOrFail($data['gajiDetail']->gaji_id);
        $data['komponen_gaji'] = KomponenGaji::pluck('nama_komponen', 'id');
        $data['pegawai'] = Pegawai::findOrFail($data['gajiDetail']->pegawai_id);

        return view('gaji.edit-gaji-detail', $data);
    }


    public function cetak($id)
    {
        $namaPerusahaan = "KLINIK NURDIN WAHID";
        $gajiPokok = 4000000;
        $gaji = Gaji::findOrFail($id);
        $pegawai = Pegawai::findOrFail($gaji->pegawai_id);
        $gajiDetail = GajiDetail::where('pegawai_id', $pegawai->id)->with('komponen_gaji')->get();

        Fpdf::AddPage('L', 'A5');
        Fpdf::SetFont('Arial', 'B', 14);
        Fpdf::Cell(190, 7, 'LAPORAN SLIP GAJI KARYAWAN', 1, 1, 'C');
        Fpdf::Cell(190, 16, '', 1, 1, 'C');
        Fpdf::SetFont('Arial', 'B', 8);

        Fpdf::text(12, 22, 'Nama Perusahaan');
        Fpdf::text(38, 22, ' : ' . $namaPerusahaan);
        Fpdf::text(12, 26, 'Periode');
        Fpdf::text(38, 26, " : 01/$gaji->periode - 31/$gaji->periode");
        Fpdf::text(12, 30, 'Departemen');
        Fpdf::text(38, 30, ' : HRD/ Admin');


        Fpdf::text(110, 22, 'NIK');
        Fpdf::text(136, 22, ' : ' . $pegawai->nip);
        Fpdf::text(110, 26, 'Nama Karyawan');
        Fpdf::text(136, 26, ' : ' . $pegawai->nama);
        Fpdf::text(110, 30, 'Jabatan');
        Fpdf::text(136, 30, ' : ' . ucfirst($pegawai->kelompok_pegawai));

        Fpdf::Cell(190, 90, '', 1, 1, 'C');
        // ---------------------------------------
        Fpdf::text(12, 40, 'Penerimaan ( +)');
        Fpdf::line(12, 75, 210 - 20, 75);
        Fpdf::line(12, 42, 110 - 20, 42);
        Fpdf::line(110, 42, 210 - 20, 42);

        $penerimaan = [
            'GPH' => 'Gaji Pokok Harian',
            'UK' => 'Uang Kehadiran',
            'UT' => 'Uang Transport / Bensi',
            'UM' => 'Uang Makan',
            'US' => 'Uang Service Motor',
            'UMK' => 'Uang Tunjangan Menikah'
        ];

        $start = 48;
        $no_penambah = 1;
        $jml_penambah = 0;

        foreach ($gajiDetail as $detail) {
            if ($detail->komponen_gaji->jenis == 'penambah') {
                Fpdf::text(12, $start, $no_penambah++);
                Fpdf::text(24, $start, $detail->komponen_gaji->nama_komponen);
                Fpdf::text(74, $start, ': ' . convert_rupiah($detail->komponen_gaji->jumlah));
                $start = $start + 5;
                $jml_penambah += $detail->komponen_gaji->jumlah;
            }
        }

        //////////////////////////////////////////////////////////////////////
        Fpdf::text(110, 40, 'Potongan ( -)');
        $potongan = [
            'PT' => 'Potogan Terlambat',
            'PA' => 'Potongan Absen',
            'PJ' => 'Potongan Jamsostek',
        ];

        $start = 48;
        $no_pengurang = 1;
        $jml_pengurang = 0;

        foreach ($gajiDetail as $detail) {
            if ($detail->komponen_gaji->jenis == 'pengurang') {
                Fpdf::text(110, $start, $no_pengurang++);
                Fpdf::text(124, $start, $detail->komponen_gaji->nama_komponen);
                Fpdf::text(174, $start, ': ' . convert_rupiah($detail->komponen_gaji->jumlah));
                $start = $start + 5;
                $jml_pengurang += $detail->komponen_gaji->jumlah;
            }
        }

        $total = $jml_penambah - $jml_pengurang;
        $totalGaji = $gajiPokok + $total;

        Fpdf::text(12, 82, 'Total Penerimaan');
        Fpdf::text(74, 82, ': ' . convert_rupiah($gajiPokok));

        Fpdf::text(12, 86, 'Gaji Yang Diterima');
        Fpdf::text(74, 86, ': ' . convert_rupiah($totalGaji));

        Fpdf::text(12, 90, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');


        Fpdf::text(12, 96, 'Nama Perusahaan');
        Fpdf::text(42, 96, ' : ' . $namaPerusahaan);
        Fpdf::text(12, 100, 'Periode');
        Fpdf::text(42, 100, " : 01/$gaji->periode - 31/$gaji->periode");
        Fpdf::text(12, 104, 'Departemen');
        Fpdf::text(42, 104, ' : HRD/ Admin');


        Fpdf::text(12, 108, 'NIK');
        Fpdf::text(42, 108, ' : ' . $pegawai->nip);
        Fpdf::text(12, 112, 'Nama Karyawan');
        Fpdf::text(42, 112, ' : ' . $pegawai->nama);
        Fpdf::text(12, 116, 'Jabatan');
        Fpdf::text(42, 116, ' : ' . ucfirst($pegawai->kelompok_pegawai));


        Fpdf::text(120, 96, 'Diserahkan Oleh');
        Fpdf::text(125, 116, 'Admin');
        Fpdf::text(110, 120, 'Tgl Cetak : ' . tgl_indo(date('Y-m-d')));
        Fpdf::text(160, 96, 'Diterima Oleh');
        Fpdf::text(163, 116, $pegawai->nama);

        Fpdf::Output();
        exit;
    }
}
