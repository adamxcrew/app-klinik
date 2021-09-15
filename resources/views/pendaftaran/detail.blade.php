@extends('layouts.app')
@section('title','Kelola Data Pasien Diagnosa')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Pasien
        <small>Pasien diagnosa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box card-height">
                    <div class="box-header card-header">
                        <strong>Informasi Pasien</strong>
                        
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Nomor Pendaftaran</strong>
                            </div>
                            <div class="col-md-7">
                                {{ $pasien->kode }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Nama</strong>
                            </div>
                            <div class="col-md-7">
                                {{ $pasien->pasien->nama }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tempat tgl lahir</strong>
                            </div>
                            <div class="col-md-7">
                                {{ $pasien->pasien->tempat_lahir }}, {{ date('d-m-Y', strtotime($pasien->pasien->tanggal_lahir)) }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Umur</strong>
                            </div>
                            <div class="col-md-7">
                                {{ hitung_umur($pasien->pasien->tanggal_lahir) }} tahun
                            </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box card-height">
                    <div class="box-header card-header">
                        <strong>Informasi Terkait</strong>
                        
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tujuan Poliklinik</strong>
                            </div>
                            <div class="col-md-7">
                                {{ $pasien->poliklinik->nama }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Tanggal Sekarang</strong>
                            </div>
                            <div class="col-md-7">
                                {{ date('d-m-Y') }}
                            </div>
                        </div>

                        <div class="card-spac">
                            <div class="col-md-5">
                                <strong>Jenis Layanan</strong>
                            </div>
                            <div class="col-md-7">
                                {{ $pasien->jenis_layanan }}
                            </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content" style="margin-top: -30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Diagnosa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Resep</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Tindakan</a>
                            </li>
                            <li style="float: inline-end;">
                                <button class="btn btn-success btn-sm">Biling Poli Selesai</button>
                            </li>
                        </ul>
                    </div>
                    <div class="box-body"> 
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                        <div class="tab-pane fade active in" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                            <div class="box">
                                <div class="box-header card-header">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            Daftar diagnosa pasien
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalDiagnosa">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                              <th scope="col">#</th>
                                              <th scope="col">Kode</th>
                                              <th scope="col">Nama Diagnosa</th>
                                              <th scope="col">Keterangan</th>
                                              <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                              <th scope="row">1</th>
                                              <td>Mark</td>
                                              <td>Otto</td>
                                              <td>@mdo</td>
                                              <td><button class="btn btn-danger btn-sm">Hapus</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                            <div class="box">
                                <div class="box-header card-header">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            Daftar resep pasien
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalResep">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode Obat</th>
                                            <th scope="col">Nama Obat</th>
                                            <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td><button class="btn btn-danger btn-sm">Hapus</button></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-two-messages" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                            <div class="box">
                                <div class="box-header card-header">
                                    <div class="row">
                                        <div class="col-md-6 text-left">
                                            Daftar Tindakan Pasien
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTindakan">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <table class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Kode Tindakan</th>
                                            <th scope="col">Nama Tindakan</th>
                                            <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <th scope="row">1</th>
                                            <td>Mark</td>
                                            <td>Otto</td>
                                            <td><button class="btn btn-danger btn-sm">Hapus</button></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

  </div>

@include('pendaftaran._modal')
@endsection

@push('scripts')

<script>
    $(document).ready(function (){

        $('.button-pilih-obat').click(function() {
            $('#modalResep').modal('toggle');
            $('#modalResepNext').modal('show');
        });

        $('.return-pilih-obat').click(function() {
            $('#modalResep').modal('show');
            $('#modalResepNext').modal('toggle');
        });

    });
</script>

<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function() {

        $('#diagnosa-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("data.diagnosa") }}',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'nama', name: 'nama' },
                { data: 'action', name: 'action' }
            ]
        });

        $('#obat-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("data.obat") }}',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'action', name: 'action' }
            ]
        });

        $('#tindakan-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("data.tindakan") }}',
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'kode', name: 'kode' },
                { data: 'tindakan', name: 'tindakan' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush