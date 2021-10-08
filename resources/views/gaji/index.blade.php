@extends('layouts.app')
@section('title','Kelola Data Gaji')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Gaji
      <small>Daftar Gaji</small>
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
            {!! Form::open(['url'=>'gaji','method'=>'GET']) !!}
            <table class="table table-bordered">
              <tr>
                <td width="200">Periode Gaji</td>
                <td width="200">
                  <input id="NoIconDemo" class="form-control" name="periode" type="text" value="{{$periode}}" />
                </td>
                <td>
                  <button type="submit" class="btn btn-danger btn btn-sm">Tampilkan</button>
                </td>
              </tr>
            </table>
            {!! Form::close() !!}
            <hr>
            <table class="table table-bordered table-striped" id="pegawai-table">
              <thead>
                <tr>
                  <th width="10">Nomor</th>
                  <th>NIP</th>
                  <th>Nama Lengkap</th>
                  <th>Periode</th>
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
<script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="{{asset('jquery-ui-month-picker-master/src/MonthPicker.js')}}"></script>

<script>
  $(function() {
    $('#NoIconDemo').MonthPicker({ Button: false });
    $("#NoIconDemo").MonthPicker('option', 'MonthFormat','yy-mm');

    
    $('#pegawai-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "/gaji?periode={{$periode}}",
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'pegawai.nip',
          name: 'pegawai.nip'
        },
        {
          data: 'pegawai.nama',
          name: 'pegawai.nama'
        },
        {
          data: 'periode',
          name: 'periode'
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
  <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="{{asset('jquery-ui-month-picker-master/src/MonthPicker.css')}}">
@endpush