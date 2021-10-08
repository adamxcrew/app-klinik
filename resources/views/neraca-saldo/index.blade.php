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
            <hr>
            @include('alert')
            {!! Form::open(['url'=>'neraca-saldo','method'=>'GET']) !!}
            <table class="table table-bordered">
                <tr>
                    <td width="200">Tanggal Mulai</td>
                    <td>
                        <div class="row">
                            <div class="col-md-3">
                              {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                            </div>
                            <div class="col-md-3">
                              {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                            </div>
                            <div class="col-md-4">
                                <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                   Filter Neraca Saldo</button>
                            </div>
                        </div>
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
      ajax: '/neraca-saldo?tanggal_awal={{$tanggal_awal}}&tanggal_akhir={{$tanggal_akhir}}',
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