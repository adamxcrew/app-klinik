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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PurchaseOrder::with('supplier')->get())
                ->addColumn('action', function ($row) {
                    $btn = \Form::open(['url' => 'purchase-order/delete/' . $row->id, 'method' => 'DELETE', 'style' => 'float:right;margin-right:5px']);
                    $btn .= "<button type='submit' class='btn btn-danger btn-sm'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    $btn .= \Form::close();
                    $btn .= '<a target="_blank" class="btn btn-danger btn-sm" href="/purchase-order/cetak/' . $row->id . '"><i class="fa fa-eye" aria-hidden="true"></i></a> ';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        
        return view('purchase-order.index');
    }

    public function create()
    {
        $data['purchase_order_detail'] = PurchaseOrderDetail::where('purchase_order_id', null)->get();
        $data['barang']                = Barang::pluck('nama_barang','id');
        $data['supplier']              = Supplier::pluck('nama_supplier','id');

        return view('purchase-order.create', $data);
    }

    public function destroyPo($id)
    {
        $data = PurchaseOrder::findOrFail($id);
        $purchase_order_detail = PurchaseOrderDetail::where('purchase_order_id',$data->id)->get();
        foreach($purchase_order_detail as $row) {
            $model = PurchaseOrderDetail::where('id',$row->id)->first();
            $model->delete();
        }
        $data->delete();
        return redirect()->back();
    }

    public function insertPurchaseOrder(Request $request)
    {
        $data = PurchaseOrderDetail::where('purchase_order_id', null)->get();

        if(count($data) == 0)
        {
            return redirect()->back()->with('message', 'Mohon pilih barang terlebih dahulu');
        }else{
            $simpan_purchase_order = PurchaseOrder::create($request->all());
            $update_purchase_order_detail = PurchaseOrderDetail::where('purchase_order_id', null)->update(['purchase_order_id'=> $simpan_purchase_order->id]);
            
            return redirect('purchase-order/cetak/'.$simpan_purchase_order->id);
        }
    }

    public function insertPurchaseOrderDetail(Request $request)
    {
        $barang = Barang::where('id', $request->barang_id)->first();

        $input = $request->all();
        $input['harga'] = $barang->harga * $request->qty;
        PurchaseOrderDetail::create($input);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $data = PurchaseOrderDetail::findOrFail($id);
        $data->delete();

        return redirect()->back();
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
