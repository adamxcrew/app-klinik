@extends('layouts.app')
@section('title','Pendaftaran Pasien Baru')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tanda Tanda Vital Dan Pemeriksa Klinis
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
                        <img src="https://img.pikbest.com/png-images/qiantu/cute-cartoon-little-girl-medical-patient-in-hospital-gown_2558435.png!c1024wm0/compress/true/progressive/true/format/webp/fw/1024" width="200">
                        <h4>{{$pendaftaran->pasien->nama}}</h4>
                        <h4>{{$pendaftaran->pasien->nomor_rekam_medis}}</h4>
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
                    <div class="col-sm-3">
                        {!! Form::text('berat_badan', null, ['class'=>'form-control','Placeholder'=>'Berat Badan']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tekanan Darah</label>
                    <div class="col-sm-3">
                        {!! Form::text('tekanan_darah', null, ['class'=>'form-control','Placeholder'=>'Tekanan Darah']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Suhu Tubuh</label>
                    <div class="col-sm-3">
                        {!! Form::text('suhu_tubuh', null, ['class'=>'form-control','Placeholder'=>'Suhu Tubuh']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Jenis Kasus</label>
                    <div class="col-sm-4">
                        {!! Form::select('jenis_kasus',['baru'=>'Jenis Kasus Baru','lama'=>'Jenis Kasus Lama'], null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                        <a href="/pendaftaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
                    </div>
                </div>
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-body">
                <h3>Pemeriksa Klinis</h3>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
