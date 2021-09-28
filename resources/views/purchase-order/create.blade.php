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
                {{ Form::open(['route' => 'purchase-order.store']) }}
                {{ Form::hidden('kode',generateKodePurchaseOrder()) }}
                  <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kode PO</label>
                        {{ Form::text('',generateKodePurchaseOrder(),['class' => 'form-control', 'required','readonly']) }}
                    </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan</label>
                            {{ Form::date('tanggal',null,['class' => 'form-control', 'required']) }}
                        </div>
                   
                        <div class="form-group">
                            <label>Supplier</label>
                            {{ Form::select('supplier_id', $supplier, null,['class' => 'form-control']) }}
                        </div>
                        
                    </div>
                  </div>

                  <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                    <div class="col-md-8">
                        <a href="{{ route('purchase-order.index')}}" class="btn btn-success btn-sm">Kembali</a>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-save"></i> Simpan</button>
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
                  <div class="row" style="padding-bottom: 20px">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Pilih Barang</label>
                        <select name="barang" class="barang form-control"></select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Qty</label>
                        {{ Form::text('qty', null, ['class' => 'form-control qty', 'placeholder' => 'qty', 'required']) }}
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <button type="button" onClick="tambah_barang()" class="btn btn-primary" style="margin-top: 25px;"><i class="fa fa-plus"></i> Tambah</button>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <div id="table_barang"></div>
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
<script>
$(document).ready(function () {
    list_barang();
    $('.barang').select2({
        placeholder: 'Cari Nama Barang',
        ajax: {
            url: '/ajax/select2Barang',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama_barang,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
});


function list_barang(){
  $.ajax({
      url: "/purchase-order-detail",
      type: "GET",
      success: function (response) {
          $("#table_barang").html(response);
      },
      error: function () {
          alert("error");
      }

  });
}

function tambah_barang()
{
  var barang_id = $(".barang").val();
  var qty       = $(".qty").val();
  if(barang_id == '' || qty == '')
  {
    alert('Barang Atau Jumlah Tidak Boleh Kosong');
  }
  $.ajax({
      url: "/purchase-order-detail",
      type: "POST",
      data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          barang_id: barang_id,
          qty: qty
      },
      success: function (response) {
          list_barang();
      },
      error: function () {
          alert("error");
      }

  });
}


function hapus_barang(id)
{
  console.log(id);
  $.ajax({
      url: "/purchase-order-detail/"+id,
      type: "DELETE",
      data: {
          _token: $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        console.log(response);
        list_barang();
      },
      error: function () {
          alert("error");
      }

  });
}
</script>
@endpush

@push('css')
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />   
@endpush