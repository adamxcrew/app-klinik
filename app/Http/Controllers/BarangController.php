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
            return DataTables::of(Barang::with('satuan', 'kategori')->get())
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
    public function show($id)
    {
        //
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
        return Excel::download(new BarangExport, 'Barang.xlsx');
    }
}
