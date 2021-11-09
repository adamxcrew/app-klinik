@extends('layouts.app')
@section('title','Pasien Terdaftar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      @if(auth()->user()->role == 'kasir') 
        <h1>
          Daftar Pasien Selesai Pelayanan
          <small></small>
        </h1>
      @else
        <h1>
          Daftar Pasien Menunggu Pelayanan
          <small></small>
        </h1>
      @endif
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
                      {!! Form::open(['url'=>'pendaftaran','method'=>'GET','id'=>'form']) !!}
                      <table class="table table-bordered">
                          <tr>
                              <td width="140">Tanggal Mulai</td>
                              <td>
                                  <div class="row">
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_awal', $tanggal_awal, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-2">
                                        {!! Form::date('tanggal_akhir', $tanggal_akhir, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                                      </div>
                                      <div class="col-md-3">
                                        {!! Form::select('poliklinik_id', $poliklinik, $poliklinik_id,['class'=>'form-control','placeholder'=>'- Semua Poli -']) !!}
                                      </div>
                                      <div class="col-md-4">
                                          <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                             Filter Laporan</button>
                                      </div>
                                  </div>
                              </td>
                          </tr>
                      </table>
                      {!! Form::close() !!}
                      <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="pendaftaran-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik Tujuan</th>
                        <th>Jenis Layanan</th>
                        <th>Status Pelayanan</th>
                        <th width="250">#</th>
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
      var parameter = $('#form').serialize();
      console.log(parameter);
      $('#pendaftaran-table').DataTable({
          processing: true,
          serverSide: true,
          daata: $('#form').serialize(),
          ajax: "/pendaftaran?tanggal_awal={{$tanggal_awal}}&tanggal_akhir={{$tanggal_akhir}}&poliklinik_id={{$poliklinik_id}}&type=web",
          columns: [
            {data: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'kode', name: 'kode' },
            { data: 'pasien.nama', name: 'pasien.nama' },
            { data: 'poliklinik.nama', name: 'poliklinik.nama' },
            { data: 'jenis_layanan', name: 'jenis_layanan' },
            { data: 'status_pelayanan', name: 'status_pelayanan' },
            { data: 'action', name: 'action' }
          ]
      });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
