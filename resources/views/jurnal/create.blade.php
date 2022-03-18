@extends('layouts.app')
@section('title','Input Jurnal Umum')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Jurnal Umum
      <small>Tambah Jurnal Umum</small>
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
            {!! Form::open(['route'=>'jurnal.store','class'=>'form-horizontal']) !!}
            @include('validation_error')
            @include('jurnal.form')
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('scripts')
<script>
  function copy_form(){
    $.ajax({
      url: "/jurnal/add_form",
      cache: false,
      success: function(html){
        console.log(html);
        $( ".new" ).after( html );
      }
    });
  }


  function hapus_form(id){
    console.log(id);
    $(".wraper-"+id).remove();
  }
</script>
@endpush

