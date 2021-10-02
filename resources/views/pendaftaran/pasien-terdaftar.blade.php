@extends('layouts.app')
@section('title','Pendaftaran Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Pendaftaran Pasien
        <small>Daftar Pasien</small>
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
                  <div class="row">
                    {!! Form::open(['route'=>'pendaftaran.store']) !!}
                    {{ Form::hidden('kode', generateKodePendaftaran()) }}
                    <div class="col-md-6">
                        <h3><strong>Tujuan</strong></h3>
                        <hr>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Pasien</label>
                            {{-- <select name="pasien_id" id="pasien" class="pasien form-control" style="height: 100px;" placeholder="Masukan Nama Pasien"></select> --}}
                            {{ Form::select('pasien_id', $daftar_pasien, $pasien_id,['class'=>'form-control select-pasien']) }}
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Jenis Pendaftaran</label>
                                    {{ Form::select('jenis_pendaftaran', $jenis_pendaftaran, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Jenis Rujukan</label>
                                    {{ Form::select('jenis_rujukan', $jenis_rujukan, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nama Perujuk</label>
                                    {{ Form::text('nama_perujuk', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Penjamin</label>
                                    {{ Form::select('penjamin', $penjamin, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nomor Surat</label>
                                    {{ Form::number('no_surat', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal Berlaku</label>
                                    {{ Form::date('tanggal_berlaku', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Penanggung Jawab</label>
                                    {{ Form::text('penanggung_jawab', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Hubungan Dengan Pasien</label>
                                    {{ Form::select('hubungan_pasien', $hubungan_pasien, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Alamat Penanggung Jawab</label>
                                    {{ Form::text('alamat_penanggung_jawab', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">No. Telp Penanggung Jawab</label>
                                    {{ Form::text('no_telp_penanggung_jawab', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">No. HP Penanggung Jawab</label>
                                    {{ Form::text('no_hp_penanggung_jawab', null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Poliklinik</label>
                                    {{ Form::select('poliklinik_id', $poliklinik, null,['class'=>'form-control poliklinik']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Dokter</label>
                                    <div id="dokter"></div>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group" style="padding-bottom: 30px;">
                            <label class="col-sm-6 control-label">Jenis Layanan</label>
                            <div class="col-sm-6">
                                {{Form::radio('jenis_layanan','umum',['class'=>'form-check-input'])}}
                                <label class="form-check-label ml-2" for="inlineRadio1" style="padding-right: 12px;">Umum</label>
                                {{Form::radio('jenis_layanan','bpjs',['class'=>'form-check-input'])}}
                                <label class="form-check-label ml-2" for="inlineRadio2">BPJS</label>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%">DAFTARKAN PASIEN</button>
                        </div>
                    </div>
                    {{ Form::close()}}

                    <div class="col-md-6">
                        <h3><strong>Detail Pasien</strong></h3>
                        <hr>
                        <div class="text-center before-select">
                            <p style="padding-bottom: 30px" class="text-pilih">Harap pilih pasien</p>

                            <img src="{{ asset('image/loading.gif') }}" alt="">
                        </div>

                        <div class="after-select">
                            <div class="row">

                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>Nama pasien</strong>
                                        <small class="small-label-antrian">Pasien detail</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="detail-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>No ktp</strong>
                                        <small class="small-label-antrian">Kartu Tanda Penduduk</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="ktp-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>No telpon</strong>
                                        <small class="small-label-antrian">Nomor telpon pasien</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="telpon-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>Tempat lahir</strong>
                                        <small class="small-label-antrian">Lahir di</small>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="tempat-lahir-pasien"></label>
                                    </div>
                                </div>
        
                                <div class="card-spac-antrian">
                                    <div class="col-md-6">
                                        <strong>Tanggal lahir</strong>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <label id="tanggal-lahir-pasien"></label>
                                    </div>
                                </div>
                                
                              </div>
                        </div>
                    </div>
                  </div>
               
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
@endsection

@push('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> --}}
<script>
    $(document).ready(function (){
        $('.before-select').show();
        $('.after-select').hide();
        $(".select-pasien").bind('change', function () {
            var pasien = $(".select-pasien").val();
            $.ajax({
                url: "/ajax/pasien",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "pasien_id": pasien
                },
                beforeSend: function(){
                    $('.before-select').show();
                    $('.after-select').hide();
                    $('.text-pilih').hide();
                },
                success: function(response) {
                    if(response){
                        $('#detail-pasien').text(response.nama);
                        $('#ktp-pasien').text(response.nomor_ktp);
                        $('#telpon-pasien').text(response.nomor_hp);
                        $('#tempat-lahir-pasien').text(response.tempat_lahir);
                        $('#tanggal-lahir-pasien').text(response.tanggal_lahir);

                        $('.before-select').hide();
                        $('.after-select').show();
                    }else{
                        $('.before-select').show();
                        $('.after-select').hide();
                        $('.text-pilih').show();
                    }
            }});
        });


        $('.poliklinik').bind('change', function () {
            var poliklinik = $(".poliklinik").val();
            $.ajax({
                url: "/ajax/dropdown-dokter-berdasarkan-poliklinik",
                type: "get",
                data: {poliklinik:poliklinik},
                success: function(response) {
                    $("#dokter").html(response);
            }});
        });

        $('.poliklinik').trigger('change');
        $('.select-pasien').trigger('change');

        // Select2 pasien
        // $('.pasien').select2({
        // placeholder: 'Cari Nama Pasien',
        // ajax: {
        // url: '/ajax/select2Pasien',
        // dataType: 'json',
        // delay: 250,
        // success: function(response) {
        //     console.log(response);
        //     if(response){
        //         response.map(function(val,index){
        //             $('#detail-pasien').text(response.nama);
        //             $('#ktp-pasien').text(response.nomor_ktp);
        //             $('#telpon-pasien').text(response.nomor_hp);
        //             $('#tempat-lahir-pasien').text(response.tempat_lahir);
        //             $('#tanggal-lahir-pasien').text(response.tanggal_lahir);
        //             })

        //             $('.before-select').hide();
        //             $('.after-select').show();
        //         }else{
        //             $('.before-select').show();
        //             $('.after-select').hide();
        //             $('.text-pilih').show();
        //         }
        //     },
        //     processResults: function (data) {
        //         return {
        //         results:  $.map(data, function (item) {
        //             return {
        //             text: item.nama,
        //             id: item.id
        //             }
        //         })
        //         };
        //     },
        //     cache: true
        //     }
        // });
    });
</script>

@endpush

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />   
@endpush