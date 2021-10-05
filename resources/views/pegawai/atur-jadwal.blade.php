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
            <div class="row" style="margin: 15px 0">
              <div class="col-md-4">
                <label for="">Tanggal Kerja</label>
                <input type="date" name="tanggal[]" class="form-control">
              </div>
              <div class="col-md-4">
                <label for="">Shift</label>
                {!! Form::select('shift_id[]',$shift, null, ['class'=>'form-control','Placeholder'=>'shift']) !!}
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-4" style="margin-left:10px;">
                <label for=""></label>
                  <a class="btn btn-danger"><i class="fa fa-plus-circle" aria-hidden="true"></i>Tambah Form</a>
                  <a href="/pegawai/1?tab=jadwal_kerja" class="btn btn-danger"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
                  <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
              </div>
            </div>
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