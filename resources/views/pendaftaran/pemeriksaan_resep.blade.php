@extends('layouts.app')
@section('title','Kelola Data Pasien Diagnosa')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Kelola Data Pasien
            <small>Pasien diagnosa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    @include('pendaftaran._informasi_umum')

    <section class="content" style="margin-top: -30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    

                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                @include('pendaftaran._tab')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Form Input Tindakan</h4>
                                <hr>
                                <table class="table table-bordered table-bordered">
                                    <tr>
                                        <th colspan="2">FORM INPUT DIAGNOSA</th>
                                    </tr>
                                    <tr>
                                        <td>Pilih Tindakan</td>
                                        <td>
                                            <select name="tindakan_id" id="tindakan_id" class='select2 form-control'>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="btn btn-primary add-item" onClick="addItem(this)"
                                                data-jenis='tindakan'>
                                                <i class="fa fa-plus"></i>
                                                Tambah
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h4>Daftar Diagnosa</h4>
                                <hr>
                                <table class="table table-bordered table-striped" width="100%"
                    id="resep-resume-table">
                    <thead>
                        <tr>
                            <th width="10">Nomor</th>
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</section>


@endsection

@push('scripts')

@endpush

@push('css')
@endpush