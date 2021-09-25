@extends('layouts.app')
@section('title','Kelola Jadwal Kerja Pegawai')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Jadwal Kerja 
      <small>Atur Jadwal Kerja Pegawai</small>
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
            {!! Form::open(['route'=>'pegawai.atur-jadwal.store','class'=>'form-horizontal']) !!}
            @for($i=0;$i<=30;$i++)
            <div class="row" style="margin: 15px 0">
              <div class="col-md-4">
                <label for="">Tanggal Kerja</label>
                <input type="date" name="tanggal[]" class="form-control">
              </div>
              <div class="col-md-4">
                <label for="">Shift</label>
                {!! Form::select('shift_id[]',$shift, null, ['class'=>'form-control','Placeholder'=>'shift']) !!}
              </div>
              <div class="col-md-4">
                <div>#</div>
                <button class="btn btn-primary">Terapkan</button>
              </div>
            </div>
            @endfor
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush