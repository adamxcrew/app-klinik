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
      <div class="col-xs-6">
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
                    <th width="10">No</th>
                    <th>Detail Layanan</th>
                    <th>Jumlah</th>
                    <th>Biaya</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                    <th width="10"></th>
                  </tr>
                  @php $jumlah = 0; $nomor = 1 @endphp
                  @foreach($userInfo->feeTindakan as $row)
                    <tr>
                      <td>{{$nomor}}</td>
                      <td>{{$row->tindakan->tindakan}}</td>
                      <td>{{$row->qty}}</td>
                      <td style="text-align:right">{{convert_rupiah($row->fee)}}</td>
                      <td>{{$row->discount}}</td>
                      <td>{{convert_rupiah(($row->fee*$row->qty)-$row->discount)}}</td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button>
                      </td>
                    </tr>
                    @php $jumlah += ($row->fee*$row->qty)-$row->discount; $nomor++ @endphp
                  @endforeach
                  @foreach($userInfo->resep as $row)
                    <tr>
                      <td>{{$nomor}}</td>
                      <td>{{$row->barang->nama_barang}} ( {{$row->satuan}} {{$row->aturan_pakai}}) </td>
                      <td>{{$row->jumlah}}</td>
                      @php
                        $harga = $row->harga;
                        if($harga <= 0 ){
                          $harga = $row->barang->harga;
                        }
                      @endphp
                       <td style="text-align:right">{{ convert_rupiah($harga)}}</td>
         
                      <td>0</td>
                      <td style="text-align:right">{{ convert_rupiah($harga*$row->jumlah)}}</td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm"><i class='fa fa-trash' aria-hidden='true'></i></button>
                      </td>
                    </tr>
                    @php $jumlah += $harga*$row->jumlah ; $nomor++ @endphp
                  @endforeach
                  <tr style="text-align:right">
                    <td colspan=4>Total Pembayaran</td>
                    <td colspan="2">{{convert_rupiah($jumlah)}}</td>
                  </tr>
                </table>
            </div>
        </div>

      </div>
      <div class="col-xs-6">
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
