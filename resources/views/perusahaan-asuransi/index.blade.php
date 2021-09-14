@extends('layouts.app')
@section('title','Kelola Data Asuransi')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Perusahaan Asuransi
      <small>Daftar Perusahaan Asuransi</small>
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
            <a href="{{route('asuransi.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Data</a>
            <hr>
            @include('alert')
            <table class="table table-bordered table-striped" id="asuransi-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>No Telp</th>
                  <th>Contact Person</th>
                  <th>No Telp CP</th>
                  <th>Mulai Kontrak</th>
                  <th>Akhir Kontrak</th>
                  <th>Kelompok Perusahaan</th>
                  <th>Kelompok</th>
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
    $('#asuransi-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/asuransi',
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'nama',
          name: 'nama'
        },
        {
          data: 'alamat',
          name: 'alamat'
        },
        {
          data: 'no_telp',
          name: 'no_telp'
        },
        {
          data: 'contact_person',
          name: 'contact_person'
        },
        {
          data: 'no_telp_cp',
          name: 'no_telp_cp'
        },
        {
          data: 'mulai_kontrak',
          name: 'mulai_kontrak'
        },
        {
          data: 'akhir_kontrak',
          name: 'akhir_kontrak'
        },
        {
          data: 'kelompok_perusahaan',
          name: 'kelompok_perusahaan'
        },
        {
          data: 'kelompok',
          name: 'kelompok'
        },
        {
          data: 'action',
          name: 'action'
        }
      ]
    });
  });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush