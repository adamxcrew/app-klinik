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
        Tambah Purchase Order 
        <small>Tambah Purchase Order</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


    <section class="content">
      @include('alert')
        <div class="row">
          <div class="col-md-5">
            <div class="box">
                <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                    <h3>Purchase Order (PO)</h3>
                </div>
              <div class="box-body">
                {{ Form::open(['route' => 'purchase-order.insert']) }}
                {{ Form::hidden('kode',generateKodePurchaseOrder()) }}
                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tanggal</label>
                            {{ Form::date('tanggal',null,['class' => 'form-control', 'required']) }}
                        </div>
                   
                        <div class="form-group">
                            <label>Supplier</label>
                            {{ Form::select('supplier_id', $supplier, null,['class' => 'form-control']) }}
                        </div>
                        
                    </div>
                  </div>

                  <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                    <div class="col-md-6">
                        <button type="reset" class="btn btn-light btn-sm"><i class="fa fa-refresh"></i> Reset</button>
                        <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                  </div>
                {{ Form::close() }}

              </div>
            </div>
          </div>

          <div class="col-md-7">
            <div class="box">
                <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                    <h3>Tambah Barang</h3>
                </div>
              <div class="box-body">
                
                {{ Form::open(['route' => 'purchase-order-detail.insert']) }}
                  <div class="row" style="padding-bottom: 20px">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Pilih Barang</label>
                        {{ Form::select('barang_id', $barang, null, ['class' => 'form-control']) }}
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Qty</label>
                        {{ Form::text('qty', null, ['class' => 'form-control', 'placeholder' => 'qty', 'required']) }}
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="margin-top: 25px;"><i class="fa fa-plus"></i> Tambah</button>
                      </div>
                    </div>
                  </div>
                  {{ Form::close() }}

                  <div class="table-responsive">
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Kode Barang</th>
                          <th scope="col">Nama Barang</th>
                          <th scope="col">Jumlah</th>
                          <th scope="col">Harga</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $total = 0; ?>
                        @foreach($purchase_order_detail as $row)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $row->barang->kode }}</td>
                          <td>{{ $row->barang->nama_barang }}</td>
                          <td>{{ $row->qty }}</td>
                          <td>@currency($row->barang->harga)</td>
                          <td>
                            {{ Form::open(['url'=>route('purchase-order-detail.destroy',['id'=>$row->id]),'method'=>'delete'])}}
                              <button class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                              </button>
                            {!! Form::close() !!}
                          </td>
                        </tr>
                        <?php $total += $row->barang->harga * $row->qty;?>
                        @endforeach
                        <tr>
                          <td></td>
                          <td colspan="3">Total</td>
                          <td colspan="2">@currency($total)</td>
                        </tr>
                      </tbody>
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
<script src="{{ asset('datatables/datatables.min.js') }}"></script>

<script>
  $('.tambah-obat').click(function(){
    console.log(1);
  });
</script>

@endpush