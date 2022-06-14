@extends('layouts.app')
@section('title','Tambah Surat')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Form Surat
        <small>Tambah Surat Baru</small>
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
                  {!! Form::open(['url'=>'surat']) !!}
                  @include('validation_error')
                 <div class="row">
                     <div class="col-md-6">
                        <h3>Form Surat</h3>
                        <hr>
                        {{ Form::hidden('jenis_surat',$jenis_surat)}}
                        {{ Form::hidden('pendaftaran_id',$pendaftaran->id)}}
                        <table class="table table-bordered">
                            <tr>
                                <td width="200">Tekanan Darah</td>
                                <td>
                                    <input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['tekanan_darah']}}" class="form-control">
                                </td>
                                <td width="200">Nadi</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['nadi']}}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Tinggi Badan</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['tinggi_badan']}}" class="form-control"></td>
                                <td>Berat Badan</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['berat_badan']}}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Suhu</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['suhu_tubuh']}}" class="form-control"></td>
                                <td>Pernafasan</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['pernafasan']??0}}" class="form-control"></td>

                            </tr>
                            <tr>
                                <td>Kesadaran</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['kesadaran']??0}}" class="form-control"></td>
                                <td>RR</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['rr']??0}}" class="form-control"></td>

                            </tr>
                            <tr>
                                <td>SPo2</td>
                                <td><input type="text" readonly="readonly" value="{{$pendaftaran->tanda_tanda_vital['saturasi_o2']??0}}" class="form-control"></td>
                            </tr>

                            @if($_GET['jenis']=='surat_sakit')
                                <tr>
                                    <td>Kesan</td>
                                    <td colspan="3">
                                        {{ Form::select('kesan',['Sakit'=>'Sakit','Tidak Sakit'=>'Tidak Sakit'],null,['class'=>'form-control'])}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Keperluan</td>
                                    <td colspan="3"><input type="text" name="keperluan" placeholder="Keterangan" required="required" class="form-control"></td>
                                </tr>
                            @elseif($_GET['jenis']=='surat_rujukan')
                                <tr>
                                    <td>Lain Lain</td>
                                    <td colspan="3">
                                        {{ Form::text('lain_lain',null,['class'=>'form-control','placeholder'=>'Lain Lain'])}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Diagnosa Sementara</td>
                                    <td colspan="3"><input type="text" name="diagnosa_sementara" placeholder="Diagnosa Sementara" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Tindakan Yang Telah Dilakukan</td>
                                    <td colspan="3"><input type="text" name="tindakan_yang_telah_dilakukan" placeholder="Tindakan Yang Telah Dilakukan" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Terapi Yang Telah Diberikan</td>
                                    <td  colspan="3"><input type="text" name="terapi_yang_telah_diberikan" placeholder="Terapi Yang Telah Diberikan" required="required" class="form-control"></td>
                                </tr>
                            @else
                                <tr>
                                    <td>Hasil Pemeriksaan</td>
                                    <td colspan="3">
                                        <input type="radio" name="hasil_pemeriksaan_mata" value="Buta Warna"> Buta Warna<br>
                                        <input type="radio" name="hasil_pemeriksaan_mata" value="Tidak Buta Warna"> Tidak Buta Warna

                                    </td>
                                </tr>
                                <tr>
                                    <td>Saran</td>
                                    <td  colspan="3"><input type="text" name="saran" placeholder="Saran" required="required" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Untuk Keperluan</td>
                                    <td colspan="3"><input type="text" name="keperluan" placeholder="Untuk Keperluan" required="required" class="form-control"></td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-danger">Simpan Dan Cetak</button>
                                </td>
                            </tr>
                        </table>
                     </div>
                     <div class="col-md-6">
                         <h3>Data Pasien</h3>
                         <hr>
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
