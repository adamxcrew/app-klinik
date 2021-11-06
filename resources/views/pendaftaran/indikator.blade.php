@php
    $jenisPemeriksaan = $pendaftaran->pasien->rujukan[0]->tindakan;
@endphp
@extends('layouts.app')
@section('title','Jenis Pemeriksaan Lab '.$jenisPemeriksaan->nama_jenis)
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Input indikator pemeriksaan laboratorium
            <small>Input indikator pemeriksaan {{$jenisPemeriksaan->nama_jenis}} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/pendaftaran">Pendaftaran </a></li>
            <li class="active">Input indikator pemeriksaan {{$jenisPemeriksaan->nama_jenis}}</li>
        </ol>
    </section>
    @include('pendaftaran._informasi_umum')
    <section class="content">
        @include('alert')
        <div class="row">
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Jenis Pemeriksaan Lab</h3>
                    </div>
                    <div class="box-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Rujukan pemeriksaan</label>
                                    {{ Form::text('nama_jenis',$jenisPemeriksaan->nama_jenis,['class' => 'form-control', 'required', 'disabled']) }}
                                </div>
                                <div class="form-group pull-right">
                                    <a href="/pendaftaran/{{$pendaftaran->id}}/input-indikator/print" class="btn btn-primary">
                                        <i class="fa fa-print"></i> Cetak PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box">
                    <div class="box-header text-center" style="border-bottom: 1px solid;padding-top: 0;">
                        <h3>Indikator Pemeriksaan Laboratorium ({{$jenisPemeriksaan->nama_jenis}})</h3>
                    </div>
                    <div class="box-body">
                        <div class="row" style="padding-bottom: 20px">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Indikator</label>
                                    <select name="indikator_pemeriksaan_lab_id" id="indikator_pemeriksaan_lab_id" class="form-control select2">
                                        @foreach($jenisPemeriksaan->indikator as $row)
                                            <option data-nilai="{{$row->nilai_rujukan}}" value="{{$row->id}}">{{$row->nama_indikator}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Nilai Normal</label>
                                    <textarea class="form-control" disabled name="nilai_rujukan" id="nilai_rujukan" cols="30" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hasil</label>
                                    {{ Form::text('hasil', null, ['class' => 'form-control hasil detail-section', 'placeholder' => 'Nilai Hasil', 'required']) }}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button id="tambah_indikator_detail" type="button" onClick="tambah_indikator()"
                                        class="btn btn-primary detail-section" style="margin-top: 25px;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" id="table-detail-section">
                            <!-- Ajax content on view jenis-pemeriksaan-lab.ajax-indikator-table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('bootstrap3-editable/js/bootstrap-editable.js')}}"></script>
<script>
$( document ).ready(function() {
	refresh_table()
    changeNilai()

    $('#indikator_pemeriksaan_lab_id').select2();
    $('#indikator_pemeriksaan_lab_id').on('change', ()=>{
        changeNilai()
    })

    $('.indikator').select2({
        placeholder: 'Cari Nama Indikator',
        ajax: {
        url: '/ajax/select2Indikator',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
                return {
                text: item.nama_indikator,
                id: item.id
                }
            })
            };
        },
        cache: true
        }
    });
});

function changeNilai(){
    let harapan =$('#indikator_pemeriksaan_lab_id option:selected').attr('data-nilai')
    $('#nilai_rujukan').val(harapan)
}

function hapus_indikator(indikator_id = null)
{
	if(indikator_id == null){
		indikator_id = $(".indikator").val();
	}

	$('.btn-hapus-indikator').prop('disabled', true)

	$.ajax({
		url: "/hasil-pemeriksaan-lab/"+indikator_id,
		type: "DELETE",
		data: {
			_token: $('meta[name="csrf-token"]').attr('content'),
			indikator_id: indikator_id
		},
		success: function (response) {
			refresh_table()
		},
		error: function () {
			alert("error");
		}

	});
}

function refresh_table(hasResponse = null){
	if(hasResponse != null){
		return $('#table-detail-section').html(hasResponse)
	}

	$.ajax({
		url : "/hasil-pemeriksaan-lab/{{$pendaftaran->id}}",
		type : "GET",
		success : (response)=>{
			$('#table-detail-section').html(response)
            $('.editableRow').editable({
				type: 'text',
				value : '',
				url: '/ajax/hasil-pemeriksaan-lab-editable',
				title: 'Masukan data baru'
			});
			$('.editableRow').on('save', (e, editable) => {
				refresh_table()
			})
            $('#datatable').DataTable()
		}
	})
}

function tambah_indikator() {
    let indikator_pemeriksaan_lab_id = $('#indikator_pemeriksaan_lab_id option:selected').val()
    let hasil = $('.hasil').val()
    let pendaftaran_id = '{{$pendaftaran->id}}'

    if(indikator_pemeriksaan_lab_id == '' || hasil == '' || pendaftaran_id == '')
    {
      return alert('Indikator Atau Jumlah Tidak Boleh Kosong');
    }

    $.ajax({
        url: "/hasil-pemeriksaan-lab",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            indikator_pemeriksaan_lab_id : indikator_pemeriksaan_lab_id,
            hasil : hasil,
            pendaftaran_id : pendaftaran_id
        },
        success: function (response) {
            refresh_table(response)
            $('#datatable').DataTable()
            $(".hasil").val('')
        },
        error: function () {
            alert("error");
        }

    });
}
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
    <link href="{{asset('bootstrap3-editable/css/bootstrap-editable.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <style>
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        table.dataTable {
            width: 100% !important;
        }
    </style>
@endpush
