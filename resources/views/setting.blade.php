@extends('layouts.app')
@section('title','Setting Aplikasi')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Halaman Setting
        <small>Setting Aplikasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-3">
                <div class="box">
                  <div class="box-body">
                    <table class="table table-bordered text-center">
                      <tr>
                        <th>Logo Instansi</th>
                      </tr>
                      <tr>
                        <td>
                          <?php
                          $logo = $setting->logo==null?'default_logo.jpg':$setting->logo;
                          ?>
                          <img class="profile-user-img img-responsive img-circle" src="{{asset('image/'.$logo)}}" alt="User profile picture">
                        </td>
                      </tr>
                    </table>          
                  </div>
                </div>
            </div>
          <div class="col-xs-9">
            <div class="box">
              <div class="box-body">
                  {!! Form::model($setting,['route'=>['setting.update'],'method'=>'PUT','class'=>'form-horizontal','files'=>true]) !!}
                  @include('validation_error')
                  @include('alert')
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Nama Klinik</label>
  
                      <div class="col-sm-10">
                        {!! Form::text('nama_instansi', null, ['class'=>'form-control','Placeholder'=>'Nama Instansi']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">Email & Telpon</label>
  
                      <div class="col-sm-5">
                        {!! Form::email('email', null, ['class'=>'form-control','Placeholder'=>'Email']) !!}
                      </div>
                      <div class="col-sm-5">
                        {!! Form::text('nomor_telpon', null, ['class'=>'form-control','Placeholder'=>'Telpon']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Alamat</label>
  
                      <div class="col-sm-10">
                        {!! Form::text('alamat',null, ['class'=>'form-control','Placeholder'=>'Alamat']) !!}
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Logo</label>
                      <div class="col-sm-10">
                        <input type="file" name="logo">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-gear" aria-hidden="true"></i> Simpan Setting</button>
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
