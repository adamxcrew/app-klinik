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
                  <a href="{{route('barang.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                     Tambah Data</a>
                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Aktif</th>
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
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'nama_barang', name: 'nama_barang' },
                { data: 'satuan.satuan', name: 'satuan.satuan' },
                { data: 'jenis_barang', name: 'jenis_barang' },
                { data: 'harga', name: 'harga' },
                { data: 'aktif', name: 'aktif' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
