@extends('layouts.app')
@section('title','Tambah Gejala')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Gejala
        <small>Tambah Gejala</small>
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
                  {!! Form::open(['route'=>'tindakan.store','class'=>'form-horizontal']) !!}
                  @include('validation_error')
                  @include('tindakan.form')
                  {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection
