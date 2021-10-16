@extends('layouts.app')
@section('title','Kelola Data Barang')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Barang
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
                <div class="row">
                  <div class="col-md-2">
                    <a href="{{route('barang.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                      Tambah Barang</a>
                  </div>
                  <a href="{{route('barang.export_excel')}}" class="btn btn btn-success btn-social btn-flat"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    Export Excel
                  </a>
                </div>

                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan Terbesar</th>
                        <th>Satuan Terkecil</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Harga + PPN</th>
                        <th>Harga Jual</th>
                        <th width="60">#</th>
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
            ajax: '/barang',
            columns: [
                { data: 'kode', name: 'kode' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'satuan_terbesar', name: 'satuan_terbesar' },
                { data: 'satuan_terkecil', name: 'satuan_terkecil' },
                { data: 'kategori.nama_kategori', name: 'kategori.nama_kategori' },
                { data: 'harga', name: 'harga' },
                { data: 'harga_ppn', name: 'harga_ppn' },
                { data: 'harga_jual', name: 'harga_jual' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
