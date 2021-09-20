@extends('layouts.app')
@section('title','Pendaftaran Pasien Baru')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Input Tanda Tanda Vital
        <small>Pendaftaran Pasien Baru</small>
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
                    <div class="box-body">
                        data pasien muncul disini
                    </div>
                </div>
            </div>
          <div class="col-xs-9">
            <div class="box">
              <div class="box-body">
                  {!! Form::model($pendaftaran,['route'=>['pendaftaran.input_tanda_vital_store',$pendaftaran->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Berat Badan</label>
                    <div class="col-sm-10">
                        {!! Form::text('berat_badan', null, ['class'=>'form-control','Placeholder'=>'Berat Badan']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tekanan Darah</label>
                    <div class="col-sm-10">
                        {!! Form::text('tekanan_darah', null, ['class'=>'form-control','Placeholder'=>'Tekanan Darah']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                        <a href="/obat" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
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
