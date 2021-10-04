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
                    @include('validation_error')
                    <div class="col-md-7">
                        <h3><strong>Tujuan Pelayanan</strong></h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Jenis Pendaftaran</label>
                                    {{ Form::select('jenis_pendaftaran', $jenis_pendaftaran, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Pasien</label>
                                    <select name="pasien_id" class="pasien form-control" placeholder="Masukan Nama Pasien"></select>
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
                                    {{ Form::text('nama_perujuk', null,['class'=>'form-control','placeholder'=>'Nama Perujuk']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nomor Surat</label>
                                    {{ Form::number('no_surat', null,['class'=>'form-control','Placeholder'=>'Nomor Surat']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Tanggal Berlaku</label>
                                    {{ Form::date('tanggal_berlaku', null,['class'=>'form-control','placeholder'=>'Tanggal Berlaku']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Penanggung Jawab</label>
                                    {{ Form::text('penanggung_jawab', null,['class'=>'form-control','Placeholder'=>'Penanggung Jawab']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Nomor HP</label>
                                    {{ Form::text('no_hp_penanggung_jawab', null,['class'=>'form-control','placeholder'=>'Nomor HP']) }}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Hubungan</label>
                                    {{ Form::select('hubungan_pasien', $hubungan_pasien, null,['class'=>'form-control']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Alamat Penanggung Jawab</label>
                                    {{ Form::text('alamat_penanggung_jawab', null,['class'=>'form-control','Placeholder'=>'Alamat Penanggung Jawab']) }}
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
                            <label class="col-sm-6 control-label">Perusahaan Penjamin</label>
                            <div class="col-sm-6">
                                {{ Form::select('jenis_layanan', $perusahaan_asuransi , null,['class'=>'form-control']) }}
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm" style="width: 100%">DAFTARKAN PASIEN</button>
                        </div>
                    </div>
                    {{ Form::close()}}

                    <div class="col-md-5">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $( document ).ready(function() {
        // check apakah hasil redirect dari form input pasien
        var str = window.location.href;
        str = str.split("/");
        if(str[5]!=undefined)
        {
            console.log('selected');
            var pasien_id = str[5];

            $('.pasien').select2({
                ajax: {
                    url: '/ajax/pasien'
                }
            });

            // Fetch the preselected item, and add to the control
            var studentSelect = $('.pasien');
            $.ajax({
                type: 'GET',
                url: '/ajax/pasien',
                data : {pasien_id:pasien_id},
            }).then(function (data) {
                console.log(data);
                // create the option and append to Select2
                var option = new Option(data.nama, data.id, true, true);
                studentSelect.append(option).trigger('change');

                // manually trigger the `select2:select` event
                studentSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });

        }

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
    
        $('.pasien').select2({
            placeholder: 'Masukan Nama Pasien',
            ajax: {
            url: '/ajax/select2Pasien',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.nama,
                        id: item.id
                    }
                })
                };
            },
            cache: true
            }
        });

        $('.pasien').on("select2:select", function (e) {
            var pasien = $('.pasien').val();
            $.ajax({
                url: "/ajax/pasien",
                type: "get",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "pasien_id": pasien
                },
                beforeSend: function () {
                    $('.before-select').show();
                    $('.after-select').hide();
                    $('.text-pilih').hide();
                },
                success: function (response) {
                    if (response) {
                        $('#detail-pasien').text(response.nama);
                        $('#ktp-pasien').text(response.nomor_ktp);
                        $('#telpon-pasien').text(response.nomor_hp);
                        $('#tempat-lahir-pasien').text(response.tempat_lahir);
                        $('#tanggal-lahir-pasien').text(response.tanggal_lahir);

                        $('.before-select').hide();
                        $('.after-select').show();
                    } else {
                        $('.before-select').show();
                        $('.after-select').hide();
                        $('.text-pilih').show();
                    }
                }
            });
        });
    });
</script>
@endpush

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />   
@endpush