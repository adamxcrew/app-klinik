@extends('layouts.app')
@section('title','Kelola Tindakan')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Tindakan
        <small>Daftar Tindakan</small>
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
                  <a href="{{route('tindakan.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
                     Tambah Data</a>
                  <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="users-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Kode ICD 9</th>
                        <th>Nama Tindakan</th>
                        <th>Jenis Tindakan</th>
                        <th>Tarif Umum</th>
                        <th>Tarif BPJS</th>
                        <th>Tarif Perusahaan</th>
                        <th>Pelayanan</th>
                        <th width="100">#</th>
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
            ajax: '/tindakan',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'tindakan', name: 'tindakan' },
                { data: 'jenis', name: 'jenis' },
                { data: 'tarif_umum', name: 'harga' },
                { data: 'tarif_bpjs', name: 'tarif_bpjs' },
                { data: 'tarif_perusahaan', name: 'tarif_perusahaan' },
                { data: 'pelayanan', name: 'pelayanan' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
