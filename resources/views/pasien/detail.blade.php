@extends('layouts.app')
@section('title','Kelola Data Pasien Diagnosa')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Pasien
        <small>Nomor antrian</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header card-header">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <strong style="font-size: 20px;">Nomor Antrian</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="label-nomor-antrian">{{ substr($pasien->kode,11, 5) }}</strong>
                            </div>
                        </div>
                        
                    </div>
                    <div class="box-body">
                      <div class="row">

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Nama Pasien</strong>
                                <small class="small-label-antrian">Pasien detail</small>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $pasien->pasien->nama }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Nomor Pendaftaran</strong>
                                <small class="small-label-antrian">Pendaftaran</small>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $pasien->kode }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Poliklinik</strong>
                                <small class="small-label-antrian">Bagian</small>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $pasien->poliklinik->nama }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Nama Dokter</strong>
                                <small class="small-label-antrian">Dokter</small>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $pasien->dokter->name }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Jenis Layanan</strong>
                                <small class="small-label-antrian">Jenis</small>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ $pasien->jenis_layanan }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Tanggal Pendaftaran</strong>
                                <small class="small-label-antrian">Tanggal</small>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ substr($pasien->created_at, 0 ,10) }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-12">
                                <a href="{{ route('pasien.cetak', ['id' => $pasien->id]) }}" class="btn btn-primary btn-sm" target="_blank" style="width:100%">Cetak Nomor Antrian</a>
                            </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </section>

  </div>

@endsection