@extends('layouts.app')
@section('title','Pasien Terdaftar')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Daftar Pasien Menunggu Pelayanan
        <small></small>
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
                <table class="table table-bordered table-striped" id="pendaftaran-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Nama Pasien</th>
                        <th>Poliklinik Tujuan</th>
                        <th>Jenis Layanan</th>
                        <th width="160">#</th>
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
        $('#pendaftaran-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/pendaftaran',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'pasien.nama', name: 'pasien.nama' },
                { data: 'poliklinik.nama', name: 'poliklinik.nama' },
                { data: 'jenis_layanan', name: 'jenis_layanan' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
