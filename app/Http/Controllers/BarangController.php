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
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

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
            return DataTables::of(Barang::with('satuanTerbesar', 'satuanTerkecil', 'kategori')->get())
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
                    return convert_rupiah($row->harga + ($row->harga * 0.1));
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
        return Excel::download(new BarangExport(), 'Barang.xlsx');
    }

    public function import_excel(Request $request)
    {
        $file = $request->file('file');
        $nama_file = $file->getClientOriginalName();
        $destinationPath = 'uploads';
        $file->move($destinationPath, $nama_file);

        $filePath = $destinationPath . '/' . $nama_file;
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($filePath);

        foreach ($reader->getSheetIterator() as $sheet) {
            $nomor = 1;
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                if ($nomor > 1) {
                    $cells                      = $row->getCells();
                    // dd($cells);
                    $jenis_barang               = $cells[1]->getValue();
                    $kode_barang                = $cells[2]->getValue();
                    $nama_barang                = $cells[3]->getValue();
                    $jumlah_satuan_terbesar     = $cells[4]->getValue();
                    $satuan_terbesar            = Satuan::firstOrCreate(['satuan' => $cells[5]->getValue()], ['satuan' => $cells[5]->getValue()]);
                    $jumlah_satuan_terkecil     = $cells[6]->getValue();
                    $satuan_terkecil            = Satuan::firstOrCreate(['satuan' => $cells[7]->getValue()], ['satuan' => $cells[7]->getValue()]);
                    $jenis                      = Kategori::firstOrCreate(['nama_kategori' => $cells[8]->getValue()], ['nama_kategori' => $cells[8]->getValue(),'jenis' => $jenis_barang]);
                    $harga                      = (int) $cells[9]->getValue();
                    $margin                     = (int) $cells[10]->getValue();
                    $untuk_penjamin             = $cells[11]->getValue();

                    $data[] = [
                        'kode'                      =>  $kode_barang,
                        'nama_barang'               =>  $nama_barang,
                        'keterangan'                =>  null,
                        'harga'                     =>  $harga,
                        'kategori_id'               =>  $jenis->id,
                        'satuan_terbesar_id'        =>  $satuan_terbesar->id,
                        'jumlah_satuan_terbesar'    =>  $jumlah_satuan_terbesar,
                        'pelayanan'                 =>  $untuk_penjamin,
                        'satuan_terkecil_id'        =>  $satuan_terkecil->id,
                        'jumlah_satuan_terkecil'    =>  $jumlah_satuan_terkecil,
                        'margin'                    =>  $margin,
                        'pbf_id'                    =>  0,
                        'aktif'                     =>  1
                    ];
                }
                Barang::insert($data);
                $nomor++;
            }
        }

        return redirect('barang')->with('message', 'Import Berhasil');
    }
}
