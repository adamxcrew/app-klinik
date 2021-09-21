<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockOpname;
use DataTables;

class StockOpnameController extends Controller
{
    public function index(Request $request)
    {
        $data['tanggal']   = $request->tanggal ?? date('Y-m-d');
        if ($request->ajax()) {
            $stockOpname = StockOpname::with('barang.satuan')
                            ->where('tanggal', $data['tanggal'])
                            ->get();

            return DataTables::of($stockOpname)
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->addColumn('selisih', function ($row) {
                    return $row->stock_sebelumnya-$row->stock_real;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('action')) {
            return 'export excel';
        }
        
        return view('stock-opname.index', $data);
    }
}
