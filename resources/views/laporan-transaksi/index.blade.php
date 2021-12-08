@extends('layouts.topnavlayout')
@section('title','Laporan Transaksi')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Transaksi
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
                {!! Form::open(['url'=>'laporan-transaksi','method'=>'GET','id'=>'form']) !!}
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
                                <div class="col-md-4">
                                    <button type="submit" name="type" value="web" class="btn btn-danger"><i class="fa fa-cogs" aria-hidden="true"></i>
                                        Filter Laporan
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
                <hr>
                @include('alert')
                <table class="table table-bordered table-striped" id="laporan-table">
                  <thead>
                      <tr>
                        <th width="10">No</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Layanan</th>
                        <th>Total Transaksi</th>
                        <th>Jenis Pembayaran</th>
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
  {!! Form::open(['route'=>'pendaftaran.import_excel', 'files' => true]) !!}
    <div class="modal fade" id="import-stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Import Data Calon Pasien</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
                <tr>
                    <td>Pilih File</td>
                    <td>
                        {!! Form::file('import_file', ['class' => 'form-control']) !!}
                    </td>
                </tr>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Upload Calon Pasien</button>
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
      $('#laporan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/laporan-transaksi?tanggal_awal={{$tanggal_awal}}&tanggal_akhir={{$tanggal_akhir}}&type=web",
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
            data: 'pasien.nama',
            name: 'pasien.nama'
          },
          {
            data: 'jenis_layanan',
            name: 'jenis_layanan'
          },
          {
            data: 'total_transaksi',
            name: 'total_transaksi'
          },
          {
            data: 'metode_pembayaran',
            name: 'metode_pembayaran'
          },
        ]
      });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
