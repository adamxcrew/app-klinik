@extends('layouts.app')
@section('title','Kelola Stock Barang')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Stock Barang
        <small>Daftar Barang</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
        
              <div class="box-body">
                {{-- <a href="{{route('barang.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                  Tambah Barang</a>
                  <a href="{{route('barang.export_excel')}}" class="btn btn btn-success btn-social btn-flat"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    Export Excel
                  </a>
                  <button type="button" class="btn btn-primary btn-social btn-flat" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-file-excel-o" aria-hidden="true"></i> Import Data
                  </button>

                  <hr> --}}
                @include('alert')
                <input type="hidden" id="poliklinik_id" value="{{Auth::user()->poliklinik_id}}">
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan Terbesar</th>
                        <th>Satuan Terkecil</th>
                        <th>Kategori</th>
                        {{-- <th>Harga</th>
                        <th>Harga + PPN</th> --}}
                        <th>Harga Jual</th>
                        <th>Sisa Stock</th>
                      </tr>
                  </thead>
              </table>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>

@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/stock?poliklinik_id='+$("#poliklinik_id").val(),
            columns: [
                { data: 'barang.kode', name: 'barang.kode' },
                { data: 'barang.nama_barang', name: 'barang.nama_barang' },
                { data: 'barang.satuan_terbesar.satuan', name: 'barang.satuan_terbesar.satuan' },
                { data: 'barang.satuan_terkecil.satuan', name: 'barang.satuan_terkecil.satuan' },
                { data: 'barang.kategori.nama_kategori', name: 'barang.kategori.nama_kategori' },
                // { data: 'barang.harga', name: 'barang.harga' },
                // { data: 'barang.harga_ppn', name: 'barang.harga_ppn' },
                { data: 'barang.harga_jual', name: 'barang.harga_jual' },
                { data: 'jumlah_stock', name: 'jumlah_stock' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
