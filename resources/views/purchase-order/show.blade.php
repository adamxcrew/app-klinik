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
                    <h3>Purchase Order (PO)</h3>
                </div>
              <div class="box-body">
                {{ Form::open(['route' => 'purchase-order.store']) }}
                {{ Form::hidden('kode',generateKodePurchaseOrder()) }}
                  <div class="row">

                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Kode PO</label>
                        {{ Form::text('',$purchase_order->kode,['class' => 'form-control', 'required','readonly']) }}
                    </div>
                        <div class="form-group">
                            <label>Tanggal Pengajuan</label>
                            {{ Form::date('tanggal',$purchase_order->tanggal,['class' => 'form-control', 'readonly']) }}
                        </div>
                   
                        <div class="form-group">
                            <label>Supplier</label>
                            {{ Form::text('',$purchase_order->supplier->nama_supplier,['class' => 'form-control', 'required','readonly']) }}
                        </div>
                        
                    </div>
                  </div>

                  <div class="row" style="padding-bottom: 30px;margin: -10px;padding-top: 12px;">
                    <div class="col-md-8">
                        <a href="{{ route('purchase-order.index')}}" class="btn btn-success btn-sm">Kembali</a>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pilih Barang</label>
                            <select name="barang" id="barang" class="barang form-control detail-section"></select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Harga</label>
                            {{ Form::text('harga', null, ['class' => 'form-control harga detail-section', 'id'=>'harga', 'placeholder' => 'Harga', 'required']) }}
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Qty</label>
                        {{ Form::text('qty', null, ['class' => 'form-control qty', 'id' => 'qty', 'placeholder' => 'qty', 'required']) }}
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
                            harga: item.harga,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('#barang').on('change', ()=>{
        let source = $("#barang :selected").data().data.harga;
        $("#harga").val(source)
    })
});

function ubah_baris(barang_id = null, nama_barang = null, harga = null, qty = null){
    $("#barang option").remove()
    $("#barang").append(new Option(nama_barang, barang_id))
    $("#harga").val(harga)
    $("#qty").val(qty)
}


function list_barang(){
  $.ajax({
      url: "/purchase-order/{{$purchase_order->id}}",
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
  var harga       = $(".harga").val();
  if(barang_id == '' || qty == '' || harga == '')
  {
    return alert('Barang , jumlah, atau harga Tidak Boleh Kosong');
  }
  $.ajax({
      url: "/purchase-order-detail/{{$purchase_order->id}}",
      type: "PUT",
      data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          barang_id: barang_id,
          harga : harga,
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

<script>
$(document).ready(()=>{

    editor = new $.fn.dataTable.Editor( {
        ajax: "/purchase-order/list-barang/{{$purchase_order->id}}",
        table: "#table-detail",
        fields: [ {
                label: "No:",
                name: "no"
            }, {
                label: "Kode Barang:",
                name: "kode"
            }, {
                label: "Nama Barang:",
                name: "nama"
            }, {
                label: "Jumlah:",
                name: "jumlah"
            }, {
                label: "Harga:",
                name: "harga"
            }
        ]
    } );
    // Activate an inline edit on click of a table cell
    $('#table-detail').on( 'click', 'tbody td:not(:first-child)', function (e) {
        editor.inline( this );
    } );
 
    $('#table-detail').DataTable( {
        processing: true,
        serverSide: true,
        ajax: "/purchase-order/list-barang/{{$purchase_order->id}}",
        columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'kode', name:'kode' },
            { data: 'nama_barang', name:'nama_barang' },
            { data: 'qty', name:'qty' },
            { data: 'harga', name:'harga' },
        ]
    } );
})
</script>
@endpush

@push('css')
    <link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <style>
        .table tbody tr:hover {
            cursor: pointer;
            background-color: #f4f4f4;
        }
    </style> 
@endpush