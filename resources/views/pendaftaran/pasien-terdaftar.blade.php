@extends('layouts.app')
@section('title','Kelola Data Pasien')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Kelola Data Pasien
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
                    {!! Form::open(['route'=>'pendaftaran.insert']) !!}
                    {{ Form::hidden('kode', generateKodePendaftaran()) }}
                    <div class="col-md-6">
                        <h3><strong>Tujuan</strong></h3>
                        <hr>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Pasien</label>
                            {{ Form::select('pasien_id', $pasien, null,['class'=>'form-control select-pasien']) }}
                        </div>

                        <div class="row">
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
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%">Tambah Pasien</button>
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

<script>
    $(document).ready(function (){
        $('.before-select').show();
        $('.after-select').hide();
        $(".select-pasien").bind('change', function () {
            var pasien = $(".select-pasien").val();
            $.ajax({
                url: "{{ route('pasien.detail') }}",
                type: "post",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": pasien
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
    });
</script>

@endpush