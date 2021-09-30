@extends('layouts.app')
@section('title','Purchase Order (PO)')
@section('content')
<style>
  .dataTables_scrollHeadInner{
      width: 100% !important;
  }
  table.dataTable{
      width: 100% !important;
  }
</style>
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Detail Purchase Order 
        <small>Purchase Order {{$purchase_order->kode}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/purchase-order"> Purchase Order</a></li>
        <li class="active">{{$purchase_order->kode}}</li>
      </ol>
    </section>


    <section class="content">
      @include('alert')
        <div class="row">
          <div class="col-md-5">
            <div class="box">
                <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                    <h3>Persetujuan Purchase Order</h3>
                </div>
                <div class="box-body">
                    {{ Form::open(['route' => ['purchase-order.approval', $purchase_order->id]]) }}
                    {{ Form::hidden('approval',null,['id' => 'approval']) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="text-sm" style ="color:#393E46">Alasan jika PO tidak disetujui (optional) </label>
                                {{ Form::textarea('alasan',$purchase_order->alasan,['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 pull-right">
                            <button onClick="$('#approval').val('false')" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Tolak</button>
                            <button onClick="$('#approval').val('true')" class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Setujui</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
          </div>

          <div class="col-md-7">
              <div class="box">
                  <div class="box-header text-center">
                      <h3>Keterangan Purchase Order</h3>
                  </div>
                  <div class="box-body">
                

                      <table class="table table-bordered">
                          <tr>
                              <td width="140">Kode PO</td><td>: {{$purchase_order->kode}}</td>
                          </tr>
                          <tr>
                              <td>Tanggal Pengajuan</td><td>: {{tgl_indo($purchase_order->tanggal)}}</td>
                          </tr>
                          <tr>
                              <td>Supplier</td><td>: {{$purchase_order->supplier->nama_supplier}}</td>
                          </tr>
                      </table>
                      <div class="table-responsive">
                          <table class="table table-bordered">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Kode Barang</th>
                                      <th>Nama Barang</th>
                                      <th>Jumlah</th>
                                      <th>Harga PO</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php $total = 0; ?>
                                  @foreach($purchase_order_detail as $row)
                                  <tr
                                      onClick="ubah_baris({{$row->barang->id}},'{{$row->barang->nama_barang}}', {{$row->harga}}, {{$row->qty}})">
                                      <th scope="row">{{ $loop->iteration }}</th>
                                      <td>{{ $row->barang->kode }}</td>
                                      <td>{{ $row->barang->nama_barang }}</td>
                                      <td>{{ $row->qty }}</td>
                                      <td>@currency($row->harga)</td>
                                  </tr>
                                  <?php $total += $row->harga * $row->qty;?>
                                  @endforeach
                              </tbody>
                              <tfoot>
                                  <tr>
                                      <td></td>
                                      <td colspan="3">Total</td>
                                      <td colspan="2">@currency($total)</td>
                                  </tr>
                              </tfoot>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </section>
  </div>
@endsection

@push('scripts')
<script src="{{asset('/select2/dist/js/select2.min.js')}}"></script>
@endpush

@push('css')
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush