@extends('layouts.app')
@section('title','Form pembayaran')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Form Pembayaran
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
            <hr>
            @include('alert')
            <h2 class="text-center"><b>Informasi Pasien</b></h2>
            <table class="table table-striped" id="pegawai-table">
              <thead>
                <tr>
                  <td width="300">Nomor KTP</td>
                  <td width="20">:</td>
                  <th>{{ $userInfo->pasien->nomor_ktp }}</th>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <th>{{ $userInfo->pasien->nama }}</th>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <th>{{ $userInfo->pasien->alamat }}</th>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <th>{{ ucfirst($userInfo->pasien->jenis_kelamin) }}</th>
                </tr>
                <tr>
                    <td>Nomor HP</td>
                    <td>:</td>
                    <th>{{ $userInfo->pasien->nomor_hp }}</th>
                </tr>
                <tr>
                    <td>Penjamin</td>
                    <td>:</td>
                    <th>{{ $userInfo->perusahaanAsuransi->nama_perusahaan }}</th>
                </tr>
                <tr>
                    <td>Dokter Yang Menangani</td>
                    <td>:</td>
                    <th>{{ $userInfo->dokter->name }}</th>
                </tr>
                <tr>
                    <td>Poliklinik</td>
                    <td>:</td>
                    <th>{{ $userInfo->poliklinik->nama }}</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
        <div class="box">
            <div class="box-body">
                <h2 class="text-center"><strong>Pembayaran</strong></h2>
                {!! Form::open(['route'=>'pembayaran.store','class'=>'form-horizontal']) !!}
                @include('validation_error')
                @include('pembayaran.form')
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
  $(function() {
    console.log('ok');
  });
</script>
@endpush
