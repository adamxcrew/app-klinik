@extends('layouts.app')
@section('title','Laporan Stock Opname')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Stock Opname
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
                  {!! Form::open(['route'=>'stock-opname.index','method'=>'GET']) !!}
                  <table class="table table-bordered">
                      <tr>
                          <td width="200">Filter Laporan Stock Opname</td>
                          <td width="180">
                            {!! Form::date('tanggal', $tanggal, ['class'=>'form-control','Placeholder'=>'Tanggal Stock Opname']) !!}
                          </td>
                          <td>
                              <button type="submit" name="type" value="filter" class="btn btn-danger">Filter</button>
                              <button type="submit" name="action" value="export_excel" class="btn btn-success">Export Excel</button>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Import Stock Opname
                                </button>
                          </td>
                      </tr>
                  </table>
                  {!! Form::close() !!}
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
                        <th>Stock Sebelumnya</th>
                        <th>Stock Real</th>
                        <th>Selisih</th>
                      </tr>
                  </thead>
              </table>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
<!-- Modal -->
{!! Form::open(['route'=>'stock-opname.store']) !!}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Import Stock Opname</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
              <tr>
                  <td>Tanggal Stock Opname</td>
                  <td> {!! Form::date('tangal', null, ['class'=>'form-control','Placeholder'=>'Tanggal Stock Opname']) !!}</td>
              </tr>
              <tr>
                  <td>Pilih File</td>
                  <td>
                      {!! Form::file('file') !!}
                  </td>
              </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-primary">Upload Stock Opname</button>
        </div>
      </div>
    </div>
  </div>
{!! Form::close() !!}
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
            ajax: '/stock-opname',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'barang.kode', name: 'barang.kode' },
                { data: 'barang.nama_barang', name: 'barang.nama_barang' },
                { data: 'barang.satuan.satuan', name: 'barang.satuan.satuan' },
                { data: 'barang.jenis_barang', name: 'barang.jenis_barang' },
                { data: 'stock_sebelumnya', name: 'stock_sebelumnya' },
                { data: 'stock_real', name: 'stock_real' },
                { data: 'selisih', name: 'selisih' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
