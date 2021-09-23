@extends('layouts.app')
@section('title','Kelola Data Detail Pegawai')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Detail Pegawai
        <small>Data Detail Pegawai</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="box">
                    <div class="box-body text-center">
                        <img src="https://img.freepik.com/free-vector/man-shows-gesture-great-idea_10045-637.jpg?size=338&ext=jpg" width="230">
                        <h4>{{ $pegawai->nama }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="box">
                    <div class="box-body">
                      <ul class="nav nav-tabs">
                        <li role="presentation" {{ $_GET['tab']=='komponen_gaji'?'class="active"':''}}><a href="/pegawai/{{$pegawai->id}}?tab=komponen_gaji">Komponen Gaji</a></li>
                        <li role="presentation" {{ $_GET['tab']=='jadwal_kerja'?'class="active"':''}}><a href="/pegawai/{{$pegawai->id}}?tab=jadwal_kerja">Jadwal Kerja</a></li>
                      </ul>
                      <hr>
                      @if($_GET['tab']=='komponen_gaji')
                        @include('pegawai.komponen_gaji')
                      @elseif($_GET['tab']=='jadwal_kerja')
                        @include('pegawai.jadwal_kerja')
                      @endif
                    </div>
                </div>
            </div>
        </div>
      </section>
  </div>



  <!-- Modal komponen gaji -->
<div class="modal fade" id="komponen-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Tambah Komponen Gaji</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {!! Form::open(['route'=>'tunjangan-gaji.store','class'=>'form-horizontal']) !!}
        <div class="modal-body">
          @include('validation_error')
          @include('tunjangan-gaji-pegawai.form')
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection