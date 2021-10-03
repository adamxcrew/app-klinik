<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Setting;
use DataTables;
use PDF;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->status_po    = config('datareferensi.status_po');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $status_po = $this->status_po;
            return DataTables::of(PurchaseOrder::with('supplier')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'purchase-order/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a target="_blank" class="btn btn-danger btn-sm" href="/purchase-order/' . $row->id . '/cetak" style="margin-right:7px"><i class="fa fa-print" aria-hidden="true"></i></a> ';
                    $btn .= "<a href='/purchase-order/".$row->id."' class='btn btn-danger btn-sm '><i class='fa fa-eye'></i></a>";
                    return $btn;
                })
                ->addColumn('status_po', function ($row) use ($status_po) {
                    return $status_po[$row->status_po];
                })
                ->addColumn('tanggal', function ($row) {
                    return tgl_indo($row->tanggal);
                })
                ->addColumn('detail', function ($row) {
                    return '<a class="btn btn-danger btn-sm" href="/purchase-order/approval-detail/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                })
                ->rawColumns(['action','detail'])
                ->addIndexColumn()
                ->make(true);
        }

        if (\Auth::user()->role == 'pimpinan') {
            return view('purchase-order.approval_pimpinan');
        }
        return view('purchase-order.index');
    }

    public function listBarang(Request $request, $id)
    {
        // dd(PurchaseOrderDetail::with('barang')->where('purchase_order_id', $id)->get());
        if($request->ajax()){
            return DataTables::of(PurchaseOrderDetail::with('barang')->where('purchase_order_id', $id)->get())
                ->editColumn('kode', function($row){
                    return $row->barang->kode;
                })
                ->editColumn('nama_barang', function($row){
                    return $row->barang->nama_barang;
                })
                ->editColumn('harga', function ($row){
                    return $row->barang->harga;
                })
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function show(Request $request, $id)
    {
        $data['purchase_order_detail'] = PurchaseOrderDetail::where('purchase_order_id', $id)->get();
        if($request->ajax()){
            return view('purchase-order.purchase-order-item', $data);
        }

        $data['purchase_order'] = PurchaseOrder::findOrFail($id);
        $data['barang']                = Barang::pluck('nama_barang', 'id', 'harga');


        return view('purchase-order.show', $data);
    }

    public function approvalDetail(Request $request, $id)
    {
        $data['purchase_order_detail'] = PurchaseOrderDetail::where('purchase_order_id', $id)->get();
        $data['purchase_order'] = PurchaseOrder::findOrFail($id);
        $data['barang']                = Barang::pluck('nama_barang', 'id', 'harga');


        return view('purchase-order.approval_pimpinan_detail', $data);
    }

    public function approval(Request $request, $id)
    {
        $request['status_po'] = "reject_by_pimpinan";
        
        if($request->approval){
            $request['status_po'] = 'approve_by_pimpinan';
        }
        
        $po = PurchaseOrder::find($id);
        $po->update($request->all());
        return redirect(route('purchase-order.index'))->with('message', 'Update sukses! '.$po->kode.' '.$this->status_po[$po->status_po]);
    }

    public function create()
    {
        $data['purchase_order_detail'] = PurchaseOrderDetail::where('purchase_order_id', null)->get();
        $data['barang']                = Barang::pluck('nama_barang', 'id');
        $data['supplier']              = Supplier::pluck('nama_supplier', 'id');

        return view('purchase-order.create', $data);
    }

    public function destroy($id)
    {
        $data                   = PurchaseOrder::findOrFail($id);
        $purchase_order_detail  = PurchaseOrderDetail::where('purchase_order_id', $data->id)->get();
        foreach ($purchase_order_detail as $row) {
            $model = PurchaseOrderDetail::where('id', $row->id)->first();
            $model->delete();
        }
        $data->delete();
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $data = PurchaseOrderDetail::where('purchase_order_id', null)->get();

        if (count($data) == 0) {
            return redirect()->back()->with('message', 'Mohon pilih barang terlebih dahulu');
        } else {
            $request['status_po']   = 'pengajuan_po';
            $simpan_purchase_order  = PurchaseOrder::create($request->all());
            $update_purchase_order_detail = PurchaseOrderDetail::where('purchase_order_id', null)->update(['purchase_order_id' => $simpan_purchase_order->id]);

            return redirect('purchase-order/' . $simpan_purchase_order->id . '/cetak');
        }
    }

    public function cetak($id)
    {
        $data['setting']               = Setting::find(1);
        $data['purchase_order']        = PurchaseOrder::find($id);
        $data['purchase_order_detail'] = PurchaseOrderDetail::where('purchase_order_id', $data['purchase_order']->id)->get();
        $pdf = PDF::loadView('purchase-order.cetak', $data)->setPaper('A4');
        return $pdf->stream();
    }
}
