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
                <h2 class="text-center"><strong>Detail Pembayaran</strong></h2>
                <table class="table table-bordered">
                  <tr style="background-color :#222d32 ;color:#ffffff;">
                    <th>No</th>
                    <th>Detail pembayaran</th>
                    <th>Fee</th>
                  </tr>
                  @php $jumlah = 0; $nomor = 1 @endphp
                  @foreach($userInfo->feeTindakan as $row)
                    <tr>
                      <td>{{$nomor}}</td>
                      <td>{{$row->tindakan->tindakan}}</td>
                      <td style="text-align:right">{{convert_rupiah($row->jumlah_fee)}}</td>
                    </tr>
                    @php $jumlah += $row->jumlah_fee ; $nomor++ @endphp
                  @endforeach
                  @foreach($userInfo->resep as $row)
                    <tr>
                      <td>{{$nomor}}</td>
                      <td>{{$row->barang->nama_barang}} ({{$row->jumlah}} {{$row->satuan}} {{$row->aturan_pakai}}) </td>
                      @php
                        $harga = $row->harga;
                        if($harga <= 0 ){
                          $harga = $row->barang->harga;
                        }
                      @endphp
                      <td style="text-align:right">{{ convert_rupiah($harga)}}</td>
                    </tr>
                    @php $jumlah += $harga ; $nomor++ @endphp
                  @endforeach
                  <tr style="text-align:right">
                    <td colspan=2>Total Pembayaran</td>
                    <td>{{convert_rupiah($jumlah)}}</td>
                  </tr>
                </table>
            </div>
        </div>
        <div class="box">
            <div class="box-body">
                <h2 class="text-center"><strong>Pembayaran</strong></h2>
                {!! Form::open(['url'=>"pembayaran/$userInfo->id/store",'class'=>'form-horizontal']) !!}
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
