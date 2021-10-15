@extends('layouts.app')
@section('title','Data Laporan Tagihan Perusahaan')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Laporan Tagihan Perusahaan
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
            @include('alert')
            {!! Form::open(['url'=>'laporan-tagihan','method'=>'GET']) !!}
            <table class="table table-bordered">
                <tr>
                    <td width="200">Periode</td>
                    <td>
                        <div class="row">
                          <div class="col-md-3">
                            {!! Form::month('periode', $periode, ['class'=>'form-control','placeholder'=>'Tanggal Mulai']) !!}
                          </div>
                          <div class="col-md-3">
                            <select name="nama_perusahaan" id="nama-perusahaan" class="perusahaan form-control" style="height: 100px;" placeholder="Masukan Nama Desa"></select>
                          </div>
                          <div class="col-md-5">
                              <button type="submit" class="btn btn-danger" style="margin-right: 10px"><i class="fa fa-cogs" aria-hidden="true"></i>Filter Laporan</button>
                              <button type="submit" name="action" value="download" class="btn btn-success btn btn-sm"><i class="fa fa-download"></i> Download Excel</button>
                          </div>
                        </div>
                    </td>
                </tr>
            </table>
            {!! Form::close() !!}
            <hr>
            <table class="table table-bordered table-striped" id="laporan-tagihan-table">
              <thead>
                <tr>
                  <th width="10">No</th>
                  <th>Tanggal</th>
                  <th>CM</th>
                  <th>Nama Pasien</th>
                  <th>Nama Tindakan</th>
                  <th>Tarif Tindakan</th>
                  {{-- <th>Kode ICD</th>
                  <th>Indonesia</th> --}}
                  <th>Dokter</th>
                  <th>Poliklinik</th>
                  <th>Perusahaan</th>
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
<!-- Select2 Perusahaan -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(function() {
    $('#laporan-tagihan-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/laporan-tagihan?periode={{$periode}}',
      columns: 
      [
        {
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'created_at',
          name: 'created_at'
        },
        {
          data: 'nomor_rekam_medis',
          name: 'nomor_rekam_medis'
        },
        {
          data: 'nama_pasien',
          name: 'nama_pasien'
        },
        {
          data: 'tindakan.tindakan',
          name: 'tindakan.tindakan'
        },
        {
          data: 'tarif_tindakan',
          name: 'tarif_tindakan'
        },
        {
          data: 'dokter',
          name: 'dokter'
        },
        {
          data: 'poliklinik',
          name: 'poliklinik'
        },
        {
          data: 'nama_perusahaan',
          name: 'nama_perusahaan'
        },
      ]
    });

    $('.perusahaan').select2({
        placeholder: 'Cari Nama Perusahaan',
        ajax: {
        url: '/ajax/select2Perusahaan',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.nama_perusahaan,
                id: item.id
                }
            })
            };
        },
        cache: true
        }
    });
  });
</script>
@endpush

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />   
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush