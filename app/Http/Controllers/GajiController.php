<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Http\Requests\GajiStoreRequest;
use Fpdf;

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
                    Gaji::create(['pegawai_id' => $pegawai->id,'periode' => $data['periode'],'status_bayar' => 0]);
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
    public function store(AkunStoreRequest $request)
    {
        Akun::create($request->all());
        return redirect(route('akun.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['akun'] = Akun::findOrFail($id);
        return view('akun.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['akun'] = Akun::findOrFail($id);
        return view('akun.edit', $data);
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
        $akun = Akun::findOrFail($id);
        $akun->update($request->all());
        return redirect(route('akun.index'))->with('message', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $akun = akun::findOrFail($id);
        $akun->delete();
        return redirect(route('akun.index'))->with('message', 'Data Berhasil Dihapus');
    }




    public function cetak($id)
    {
        Fpdf::AddPage('L', 'A5');
        Fpdf::SetFont('Arial', 'B', 14);
        Fpdf::Cell(190, 7, 'LAPORAN SLIP GAJI KARYAWAN', 1, 1, 'C');
        Fpdf::Cell(190, 16, '', 1, 1, 'C');
        Fpdf::SetFont('Arial', 'B', 8);

        Fpdf::text(12, 22, 'Nama Perusahaan');
        Fpdf::text(38, 22, ' : PT CIPTA KARYA MANDIRI');
        Fpdf::text(12, 26, 'Periode');
        Fpdf::text(38, 26, ' : 01/04/2019 - 01/05/2019');
        Fpdf::text(12, 30, 'Departemen');
        Fpdf::text(38, 30, ' : HRD/ Admin');


        Fpdf::text(110, 22, 'NIK');
        Fpdf::text(136, 22, ' : TI102132');
        Fpdf::text(110, 26, 'Nama Karyawan');
        Fpdf::text(136, 26, ' : Nuris Akbar');
        Fpdf::text(110, 30, 'Jabatan');
        Fpdf::text(136, 30, ' : HRD/ Admin');

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
        foreach ($penerimaan as $kodeKomponen => $namaKomponen) {
            Fpdf::text(12, $start, $kodeKomponen);
            Fpdf::text(24, $start, $namaKomponen);
            Fpdf::text(74, $start, ': 40.000');
            $start = $start + 5;
        }

        //////////////////////////////////////////////////////////////////////

        Fpdf::text(110, 40, 'Potongan ( -)');
        $potongan = [
            'PT' => 'Potogan Terlambat',
            'PA' => 'Potongan Absen',
            'PJ' => 'Potongan Jamsostek',
        ];
        $start = 48;
        foreach ($potongan as $kodePotongan => $namaPotongan) {
            Fpdf::text(110, $start, $kodePotongan);
            Fpdf::text(124, $start, $namaPotongan);
            Fpdf::text(174, $start, ': 30.000');
            $start = $start + 5;
        }

        Fpdf::text(12, 82, 'Total Penerimaan');
        Fpdf::text(74, 82, ': 4.000.000');

        Fpdf::text(12, 86, 'Gaji Yang Diterima');
        Fpdf::text(74, 86, ': 4.000.000');

        Fpdf::text(12, 90, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------');


        Fpdf::text(12, 96, 'Nama Perusahaan');
        Fpdf::text(42, 96, ' : PT CIPTA KARYA MANDIRI');
        Fpdf::text(12, 100, 'Periode');
        Fpdf::text(42, 100, ' : 01/04/2019 - 01/05/2019');
        Fpdf::text(12, 104, 'Departemen');
        Fpdf::text(42, 104, ' : HRD/ Admin');


        Fpdf::text(12, 108, 'NIK');
        Fpdf::text(42, 108, ' : TI102132');
        Fpdf::text(12, 112, 'Nama Karyawan');
        Fpdf::text(42, 112, ' : Nuris Akbar');
        Fpdf::text(12, 116, 'Jabatan');
        Fpdf::text(42, 116, ' : HRD/ Admin');



        Fpdf::text(120, 96, 'Diserahkan Oleh');
        Fpdf::text(125, 116, 'Admin');
        Fpdf::text(110, 120, 'Tgl Cetak : ' . date('d/m/Y : H:i:s'));
        Fpdf::text(160, 96, 'Diterima Oleh');
        Fpdf::text(163, 116, 'Nuris Akbar');

        Fpdf::Output();
        exit;
    }
}
