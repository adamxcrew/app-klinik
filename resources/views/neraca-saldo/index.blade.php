@extends('layouts.app')
@section('title','Daftar Neraca Saldo')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Neraca Saldo
      <small>Daftar Neraca Saldo</small>
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
            @include('validation_error')
            <hr>
            @include('alert')
            {!! Form::open(['url'=>'neraca-saldo','method'=>'GET']) !!}
            <table class="table table-bordered">
              <tr>
                <td width="200">Periode</td>
                <td width="200">
                  <input class="form-control" name="periode" type="month" value="{{$periode}}" />
                </td>
                <td width="130">
                  <button type="submit" class="btn btn-danger btn btn-sm">Tampilkan</button>
                </td>
                <td>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-export">
                    <i class="fa fa-download"></i> Export Excel
                  </button>
                </td>
              </tr>
            </table>
            {!! Form::close() !!}
            <table class="table table-bordered table-striped" id="users-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Kode</th>
                  <th>Nama Akun</th>
                  <th>Kredit</th>
                  <th>Debet</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Modal Export Excel-->
<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export data neraca saldo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {{ Form::open(['route' => 'neraca-saldo.export_excel', 'method' => 'post']) }}
      <div class="modal-body">
        <table class="table table-bordered">
          <tr>
            <th>Periode</th>
            <td><input type="month" name="periode" class="form-control"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Download</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
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
      ajax: '/neraca-saldo?periode={{$periode}}',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'kode',
          name: 'kode'
        },
        {
          data: 'akun',
          name: 'akun'
        },
        {
          data: 'kredit',
          name: 'kredit'
        },
        {
          data: 'debet',
          name: 'debet'
        },
      ]
    });
  });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush