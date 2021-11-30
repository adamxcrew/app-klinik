@extends('layouts.topnavlayout')
@section('title','Pendaftaran Pasien Baru')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tanda Tanda Vital Dan Pemeriksa Klinis
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
      {!! Form::model($pendaftaran,['route'=>['pendaftaran.input_tanda_vital_store',$pendaftaran->id],'method'=>'PUT','class'=>'form-horizontal']) !!}
        <div class="row">
          <div class="col-xs-9">
            <div class="box">
              <div class="box-body">
                  @include('validation_error')
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Berat Badan</label>
                    <div class="col-sm-3">
                        {!! Form::text('berat_badan', null, ['class'=>'form-control','Placeholder'=>'Berat Badan']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tinggi Badan</label>
                    <div class="col-sm-3">
                        {!! Form::text('tinggi_badan', null, ['class'=>'form-control','Placeholder'=>'Tekanan Darah']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Tekanan Darah</label>
                    <div class="col-sm-3">
                        {!! Form::text('tekanan_darah', null, ['class'=>'form-control','Placeholder'=>'Tekanan Darah']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Suhu Tubuh</label>
                    <div class="col-sm-3">
                        {!! Form::text('suhu_tubuh', null, ['class'=>'form-control','Placeholder'=>'Suhu Tubuh']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nadi</label>
                    <div class="col-sm-3">
                        {!! Form::text('nadi', null, ['class'=>'form-control','Placeholder'=>'Nadi']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">RR</label>
                    <div class="col-sm-3">
                        {!! Form::text('rr', null, ['class'=>'form-control','Placeholder'=>'RR']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Saturasi O2</label>
                    <div class="col-sm-3">
                        {!! Form::text('saturasi_o2', null, ['class'=>'form-control','Placeholder'=>'Saturasi O2']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Fungsi Penciuman</label>
                    <div class="col-sm-3">
                        {!! Form::select('fungsi_penciuman',['Normal'=>'Normal','Tidak Normal'=>'Tidak Normal'], null, ['class'=>'form-control','Placeholder'=>'Fungsi Penciuman']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Status Alergi</label>
                    <div class="col-sm-1" style="width:10px;">
                      <input type="checkbox" id = 'status_alergi' name="status_alergi">
                    </div>
                    <div class="col-sm-6">
                        {!! Form::text('status_alergi_value', null, [ 'id' => 'status_alergi_value', 'class'=>'form-control','Placeholder'=>'Status Alergi','disabled']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Jenis Kasus</label>
                    <div class="col-sm-4">
                        {!! Form::select('jenis_kasus',['baru'=>'Jenis Kasus Baru','lama'=>'Jenis Kasus Lama'], null, ['class'=>'form-control']) !!}
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box">
                <div class="box-body text-center">
                    <img src="https://img.pikbest.com/png-images/qiantu/cute-cartoon-little-girl-medical-patient-in-hospital-gown_2558435.png!c1024wm0/compress/true/progressive/true/format/webp/fw/1024" width="200">
                    <h4>{{$pendaftaran->pasien->nama}}</h4>
                    <h4>{{$pendaftaran->pasien->nomor_rekam_medis}}</h4>
                </div>
            </div>
        </div>
        </div>
        <div class="box">
          <div class="box-body">
            <h3>Riwayat Penyakit</h3>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4>Form Input Riwayat Penyakit</h4>
                    <hr>
                    <table class="table table-bordered table-bordered">
                        <tr>
                            <th colspan="2">FORM INPUT RIWAYAT PENYAKIT</th>
                        </tr>
                        <tr>
                            <td>Pilih Riwayat</td>
                            <td>
                                <select name="riwayat_penyakit_id" id="riwayat_penyakit_id" class='select2 form-control'>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="btn btn-primary add-item" onClick="addRiwayatPenyakit(this)" >
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Daftar Riwayat Penyakit</h4>
                    <hr>
					<div id="table-riwayat-penyakit">
						<table class="table table-bordered table-striped" width="100%" id="riwayat-penyakit-table">
                            <thead>
                                <tr>
                                    <th width="10">Nomor</th>
                                    <th width="10">Kode</th>
                                    <th>Riwayat Penyakit</th>
                                    <th width="70">#</th>
                                </tr>
                            </thead>
							<tbody>
								<tr>
									<td colspan=3 style="text-align:center">Tidak ada riwayat penyakit</td>
								</tr>
							</tbody>
                        </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="box">
          <div class="box-body">
            <h3>Pemeriksa Klinis</h3>
            <hr>
            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Kepala</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="kepala">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["kepala"]', null, ['class'=>'form-control input input-kepala','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Dahi Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="dahi-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["dahi_kanan"]', null, ['class'=>'form-control input input-dahi-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Pelipis Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="pelipis-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["pelipis_kanan"]', null, ['class'=>'form-control input input-pelipis-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Dahi Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="dahi-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["dahi_kiri"]', null, ['class'=>'form-control input input-dahi-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Pelipis Kiri</label>
                <div class="input-group" id="pelipis-kiri">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="pelipis-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["pelipis_kiri"]', null, ['class'=>'form-control input input-pelipis-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Mata Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="mata-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["mata_kanan"]', null, ['class'=>'form-control input input-mata-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Hidung Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="hidung-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["hidung_kanan"]', null, ['class'=>'form-control input input-hidung-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Mata Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="mata-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["mata_kiri"]', null, ['class'=>'form-control input input-mata-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Hidung Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="hidung-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["hidung_kiri"]', null, ['class'=>'form-control input input-hidung-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Mulut</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="mulut">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["mulut"]', null, ['class'=>'form-control input input-mulut','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Gigi</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="gigi">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["gigi"]', null, ['class'=>'form-control input input-gigi','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Lidah</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="lidah">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["lidah"]', null, ['class'=>'form-control input input-lidah','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Dagu</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="dagu">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["dagu"]', null, ['class'=>'form-control input input-dagu','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Pipi Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="pipi-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["pipi_kanan"]', null, ['class'=>'form-control input input-pipi-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Rahang Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="rahang-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["rahang_kanan"]', null, ['class'=>'form-control input input-rahang-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Pipi Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="pipi-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["pipi_kiri"]', null, ['class'=>'form-control input input-pipi-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Rahang Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="rahang-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["rahang_kiri"]', null, ['class'=>'form-control input input-rahang-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Telinga Kanan</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="telinga-kanan">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["telinga_kanan"]', null, ['class'=>'form-control input input-telinga-kanan','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3"></div>
                  <div class="col-md-3">
                    <label for="">Telinga Kiri</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="telinga-kiri">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["telinga_kiri"]', null, ['class'=>'form-control input input-telinga-kiri','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Bahu Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="bahu-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["bahu_kanan"]', null, ['class'=>'form-control input input-bahu-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Dada Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="dada-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["dada_kanan"]', null, ['class'=>'form-control input input-dada-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Bahu Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="bahu-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["bahu_kiri"]', null, ['class'=>'form-control input input-bahu-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Dada Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="dada-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["dada_kiri"]', null, ['class'=>'form-control input input-dada-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Leher</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="leher">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["leher"]', null, ['class'=>'form-control input input-leher','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Tenggorokan</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="tenggorokan">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["tenggorokan"]', null, ['class'=>'form-control input input-tenggorokan','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Jakun</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jakun">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jakun"]', null, ['class'=>'form-control input input-jakun','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Tulang Rusuk Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="tulang-rusuk-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["tulang_rusuk_kanan"]', null, ['class'=>'form-control input input-tulang-rusuk-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Perut Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="perut-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["perut_kanan"]', null, ['class'=>'form-control input input-perut-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Tulang Rusuk Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="tulang-rusuk-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["tulang_rusuk_kiri"]', null, ['class'=>'form-control input input-tulang-rusuk-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Perut Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="perut-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["perut_kiri"]', null, ['class'=>'form-control input input-perut-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Pusar</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="pusar">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["pusar"]', null, ['class'=>'form-control input input-pusar','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Pinggul Kanan</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="pinggul-kanan">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["pinggul_kanan"]', null, ['class'=>'form-control input input-pinggul-kanan','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Pinggul Kiri</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="pinggul-kiri">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["pinggul_kiri"]', null, ['class'=>'form-control input input-pinggul-kiri','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Penis</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="penis">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["penis"]', null, ['class'=>'form-control input input-penis','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Scrotum</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="scrotum">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["scrotum"]', null, ['class'=>'form-control input input-scrotum','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Vagina</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="input-vagina">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["vagina"]', null, ['class'=>'form-control input input-vagina','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Klitoris</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="klitoris">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["klitoris"]', null, ['class'=>'form-control input input-klitoris','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Telapak Kaki Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="telapak-kaki-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["telapak_kaki_kanan"]', null, ['class'=>'form-control input input-telapak-kaki-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Tumit Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="tumit-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["tumit_kanan"]', null, ['class'=>'form-control input input-tumit-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Telapak Kaki Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="telapak-kaki-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["telapak_kaki_kiri"]', null, ['class'=>'form-control input input-telapak-kaki-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Tumit Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="tumit-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["tumit_kiri"]', null, ['class'=>'form-control input input-tumit-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Jari Kaki Kanan</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jari-kaki-kanan">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jari_kaki_kanan"]', null, ['class'=>'form-control input input-jari-kaki-kanan','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3"></div>
                  <div class="col-md-3">
                    <label for="">Jari Kaki Kiri</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jari-kaki-kiri">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jari_kaki_kiri"]', null, ['class'=>'form-control input input-jari-kaki-kiri','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Lengan Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="lengan-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["lengan_kanan"]', null, ['class'=>'form-control input input-lengan-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Siku Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="siku-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["siku_kanan"]', null, ['class'=>'form-control input input-siku-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Lengan Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="lengan-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["lengan_kiri"]', null, ['class'=>'form-control input input-lengan-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Siku Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="siku-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["siku_kiri"]', null, ['class'=>'form-control input input-siku-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Pergelangan Tangan Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="pergelangan-tangan-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["pergelangan_tangan_kanan"]', null, ['class'=>'form-control input input-pergelangan-tangan-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Telapak Tangan Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="telapak-tangan-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["telapak_tangan_kanan"]', null, ['class'=>'form-control input input-telapak-tangan-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Pergelangan Tangan Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="pergelangan-tangan-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["pergelangan_tangan_kiri"]', null, ['class'=>'form-control input input-pergelangan-tangan-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Telapak Tangan Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="telapak-tangan-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["telapak_tangan_kiri"]', null, ['class'=>'form-control input input-telapak-tangan-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Jari Tangan Kanan Pada Jari</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jari-tangan-kanan-pada-jari">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jari_tangan_kanan_pada_jari"]', null, ['class'=>'form-control input input-jari-tangan-kanan-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Pada Ruas Jari</label>
                    <div class="input-group">
                          {!! Form::text('pemeriksaan_klinis["tangan_kanan_pada_ruas_jari"]', null, ['class'=>'form-control input input-jari-tangan-kanan-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Jari Tangan Kiri Pada Jari</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jari-tangan-kiri-pada-jari">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jari_tangan_kiri_pada_jari"]', null, ['class'=>'form-control input input-jari-tangan-kiri-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Pada Ruas Jari</label>
                    <div class="input-group">
                          {!! Form::text('pemeriksaan_klinis["kiri_pada_ruas_jari"]', null, ['class'=>'form-control input input-jari-tangan-kiri-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Paha Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="paha-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["paha_kanan"]', null, ['class'=>'form-control input input-paha-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Lutut Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="lutut-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["lutut_kanan"]', null, ['class'=>'form-control input input-lutut-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Paha Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="paha-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["paha_kiri"]', null, ['class'=>'form-control input input-paha-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Lutut Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="lutut-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["lutut_kiri"]', null, ['class'=>'form-control input input-lutut-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Betis Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="betis-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["betis_kanan"]', null, ['class'=>'form-control input input-betis-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Tulang Kering Kanan</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="tulang-kering-kanan">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["tulang_kering_kanan"]', null, ['class'=>'form-control input input-tulang-kering-kanan','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Betis Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="betis-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["betis_kiri"]', null, ['class'=>'form-control input input-betis-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-3 my-1">
                <label for="">Tulang Kering Kiri</label>
                <div class="input-group">
                      <span class="input-group-addon">
                        <input type="checkbox" class="check" data-name="tulang-kering-kiri">
                      </span>
                      {!! Form::text('pemeriksaan_klinis["tulang_kering_kiri"]', null, ['class'=>'form-control input input-tulang-kering-kiri','Placeholder'=>'Keterangan']) !!}
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Pergelangan Kaki Kanan</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="pergelangan-kaki-kanan">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["pergelangan_kaki_kanan"]', null, ['class'=>'form-control input input-pergelangan-kaki-kanan','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3"></div>
                  <div class="col-md-3">
                    <label for="">Pergelangan Kaki Kiri</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="pergelangan-kaki-kiri">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["pergelangan_kaki_kiri"]', null, ['class'=>'form-control input input-pergelangan-kaki-kiri','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Jari Kaki Kanan Pada Jari</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jari-kaki-kanan-pada-jari">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jari_kaki_kanan_pada_jari"]', null, ['class'=>'form-control input input-jari-kaki-kanan-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Pada Ruas Jari</label>
                    <div class="input-group">
                          {!! Form::text('pemeriksaan_klinis["kaki_kanan_pada_ruas_jari"]', null, ['class'=>'form-control input input-jari-kaki-kanan-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Jari Kaki Kiri Pada Jari</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="jari-kaki-kiri-pada-jari">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["jari_kaki_kiri_pada_jari"]', null, ['class'=>'form-control input input-jari-kaki-kiri-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                  <div class="col-md-3">
                    <label for="">Pada Ruas Jari</label>
                    <div class="input-group">
                          {!! Form::text('pemeriksaan_klinis["kaki_kiri_pada_ruas_jari"]', null, ['class'=>'form-control input input-jari-kaki-kiri-pada-jari','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 my-1">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Uraian Lain-lain</label>
                    <div class="input-group">
                          <span class="input-group-addon">
                            <input type="checkbox" class="check" data-name="uraian-lain-lain">
                          </span>
                          {!! Form::text('pemeriksaan_klinis["uraian_lain_lain"]', null, ['class'=>'form-control input input-uraian-lain-lain','Placeholder'=>'Keterangan']) !!}
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <div class="col-sm-offset-0 col-sm-10">
                    <hr>
                      <button type="submit" class="btn btn-danger btn btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
                      <a href="/pendaftaran" class="btn btn-danger btn btn-sm"><i class="fa fa-share-square-o" aria-hidden="true"></i> Kembali</a>
                  </div>
              </div>
              </div>
          </div>
        </div>
      {!! Form::close() !!}
      </section>
  </div>
@endsection



@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
@endpush

@push('scripts')
<script src="{{asset('/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(document).ready(function () {
		    getRiwayatPenyakit()
        $('#riwayat_penyakit_id').select2({
            placeholder: 'Cari Riwayat Penyakit',
            multiple: false,
            ajax: {
                url: '/ajax/select2ICD',
                dataType: 'json',
                delay: 250,
                multiple: false,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.indonesia,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $('.input').attr('disabled', 'disabled')

        $("#status_alergi").change(function () {
            $('#status_alergi_value').prop('disabled', true)
            $('#status_alergi_value').val('')
            if (this.checked) {
                $('#status_alergi_value').prop('disabled', false)
            }
        });

        $(".check").click(function () {
            let name = $(this).attr('data-name');
            let status = $('.input-' + name).attr('disabled');

            if (status === undefined) {
                $('.input-' + name).attr('disabled', 'disabled');
            }

            if (status == "disabled") {
                $('.input-' + name).removeAttr('disabled');
            }

            return true;
        });
    });

	function getRiwayatPenyakit() {
        $('#riwayat-penyakit-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
				url : '{{ route("resume.riwayatPenyakit") }}',
				data : {
					id : '{{$pendaftaran->id}}'
				}
			},
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'tbm_icd',
                    name: 'tbm_icd'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

	function addRiwayatPenyakit(btn) {
        let riwayatPenyakit = $('#riwayat_penyakit_id').find(':selected').val()
        $.ajax({
            url : '/riwayat-penyakit-add-item/{{$pendaftaran->id}}',
            method : 'POST',
            data : {
				_token : '{{csrf_token()}}',
                tbm_icd : riwayatPenyakit,
            },
            success : (response)=>{
                $('#table-riwayat-penyakit').html(response)
				getRiwayatPenyakit()
            }
        })
	}

	function removeRiwayatPenyakit(btn) {
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/riwayat-penyakit-remove-item/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-riwayat-penyakit').html(response)
				getRiwayatPenyakit()
            }
        })
    }
</script>

@endpush
