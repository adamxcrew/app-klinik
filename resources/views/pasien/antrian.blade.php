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
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="alert alert-primary bg-primary">
                    Pasien ditambahkan
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header card-header">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <strong style="font-size: 20px;">Nomor Antrian</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="label-nomor-antrian">3</strong>
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
                                Wahyu Safrizal
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Nomor Pendaftaran</strong>
                                <small class="small-label-antrian">Pendaftaran</small>
                            </div>
                            <div class="col-md-6 text-right">
                                PS-20210911-
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Poliklinik</strong>
                                <small class="small-label-antrian">Bagian</small>
                            </div>
                            <div class="col-md-6 text-right">
                                UMUM
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Nama Dokter</strong>
                                <small class="small-label-antrian">Dokter</small>
                            </div>
                            <div class="col-md-6 text-right">
                                dr. Resti Amalia
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Status Antrian</strong>
                                <small class="small-label-antrian">Status</small>
                            </div>
                            <div class="col-md-6 text-right">
                                <span class="status-antrian">Mengantri untuk diagnosa</span>
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-6">
                                <strong>Tanggal Pendaftaran</strong>
                            </div>
                            <div class="col-md-6 text-right">
                                {{ date('d-m-Y') }}
                            </div>
                        </div>

                        <div class="card-spac-antrian">
                            <div class="col-md-12">
                                <a href="{{ route('pasien.cetak', ['id' => 1]) }}" class="btn btn-primary btn-sm" target="_blank" style="width:100%">Cetak Nomor Antrian</a>
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