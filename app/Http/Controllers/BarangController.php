<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Http\Requests\BarangStoreRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;
use App\Jobs\ImportBarangExcel;
use App\Models\DistribusiStock;

class BarangController extends Controller
{
    protected $jenis_barang;

    public function __construct()
    {
        $this->jenis_barang    = config('datareferensi.jenis_barang');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search         = $request->input('search.value');
            $columns        = $request->get('columns');
            $count_total    = Barang::count();
            $count_filter  = $count_total;
            $items = Barang::with('satuanTerbesar', 'satuanTerkecil', 'kategori')->limit(10);

            return DataTables::of(Barang::with('satuanTerbesar', 'satuanTerkecil', 'kategori'))
                // ->with([
                //     'recordsTotal' => $count_total,
                //     'recordsFiltered' => $count_filter,
                // ])
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'barang/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a class="btn btn-danger btn-sm" href="/barang/' . $row->id . '/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                    return $btn;
                })
                ->addColumn('aktif', function ($row) {
                    return $row->aktif == 1 ? 'Aktif' : 'Tidak Aktif';
                })
                ->addColumn('harga', function ($row) {
                    return convert_rupiah($row->harga);
                })
                ->addColumn('satuan_terbesar', function ($row) {
                    return $row->jumlah_satuan_terbesar . ' ' . $row->satuanTerbesar->satuan;
                })
                ->addColumn('satuan_terkecil', function ($row) {
                    return $row->jumlah_satuan_terkecil . ' ' . $row->satuanTerkecil->satuan;
                })
                ->addColumn('harga_ppn', function ($row) {
                    return convert_rupiah($row->harga + ($row->harga * 0.11));
                })
                ->addColumn('harga_jual', function ($row) {
                    // $harga_ppn = $row->harga + ($row->harga * 0.1); /// harga + ppn 10%
                    // $harga_ppn_margin = $harga_ppn; // harga ppn * margin
                    return convert_rupiah($row->harga_jual);
                })
                ->rawColumns(['action', 'code'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('barang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['satuan']         = Satuan::pluck('satuan', 'id');
        $data['kategori']       = Kategori::pluck('nama_kategori', 'id');
        $data['jenis_barang']   = $this->jenis_barang;
        return view('barang.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BarangStoreRequest $request)
    {
        Barang::create($request->all());
        return redirect(route('barang.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            return Barang::findOrFail($id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['barang']         = Barang::findOrFail($id);
        $data['satuan']         = Satuan::pluck('satuan', 'id');
        $data['kategori']       = Kategori::pluck('nama_kategori', 'id');
        $data['jenis_barang']   = $this->jenis_barang;
        return view('barang.edit', $data);
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
        $barang = Barang::findOrFail($id);
        $barang->update($request->all());
        return redirect(route('barang.index'))->with('message', 'Data Barang Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect(route('barang.index'))->with('message', 'Data Barang Berhasil Dihapus');
    }

    public function export_excel()
    {
        return Excel::download(new BarangExport(), 'Barang.xlsx');
    }

    public function import_excel(Request $request)
    {
        // $file = $request->file('file');
        // $nama_file = $file->getClientOriginalName();
        // $destinationPath = 'uploads';
        // $file->move($destinationPath, $nama_file);
        // $filePath = $destinationPath . '/' . $nama_file;
        //$filePath = "uploads/template_import_barang_ok.xlsx";
        $nama_file = "Daftar_Harga_fix.xlsx";
        ImportBarangExcel::dispatch($nama_file);
        return redirect('barang')->with('message', 'Import Data Sedang Diproses, Check Hasilnya Berkala');
    }


    public function stock(Request $request)
    {
        if ($request->ajax()) {
            $distribusiStock = DistribusiStock::with('barang.satuanTerbesar', 'barang.satuanTerkecil', 'barang.kategori')
                            ->where('poliklinik_id', $request->poliklinik_id);
            return DataTables::of($distribusiStock)
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('poliklinik.stock');
    }
}
