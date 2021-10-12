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
                                        <th colspan="2">FORM INPUT TINDAKAN</th>
                                    </tr>
                                    <tr>
                                        <td>Pilih Tindakan</td>
                                        <td>
                                            <select name="tindakan_id" id="tindakan_id" class='select2 form-control'>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dokter</td>
                                        <td>
                                            {!! Form::select('dokter', $dokter, null, ['class'=>'form-control']) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Asistensi</td>
                                        <td>
                                            {!! Form::select('asisten', $dokter, null, ['class'=>'form-control']) !!}
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
                                <h4>Daftar Tindakan</h4>
                                <hr>
                                <div id="table-tindakan">
                                    <table class="table table-bordered table-striped" width="100%"
                                        id="tindakan-resume-table">
                                        <thead>
                                            <tr>
                                                <th width="10">Nomor</th>
                                                <th>Kode</th>
                                                <th>Nama Tindakan</th>
                                                <th width="70">#</th>
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
        </div>
</section>

@include('pendaftaran._modal')
@include('loading')
@endsection

@push('scripts')
<!-- DataTables -->
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset('datatables/datatables.min.js') }}"></script>
<script>
    function addItem(btn){
        let jenis = btn.getAttribute('data-jenis')
        let input = $('#tindakan_id').select2('data'); //return array object
        let data = []
        input.forEach(element => {
            data.push(element.id)
        });
        $.ajax({
            url : '/pendaftaran-add-item/{{$pendaftaran->id}}',
            method : 'GET',
            data : {
                jenis :jenis,
                item : data
            },
            success : (response)=>{
                $('#table-'+jenis).html(response)
                if(jenis == 'tindakan'){
                    getResumeTindakan()
                }
            }
        })
    }

    function removeItem(btn) {
        let jenis = btn.getAttribute('data-jenis')
        let id = btn.getAttribute('data-id')
        $.ajax({
            url :'/resume/tindakan/'+id,
            method : 'DELETE',
            data : {
                _token : '{{csrf_token()}}'
            },
            success : (response)=>{
                $('#table-'+jenis).html(response)
                if(jenis == 'tindakan'){
                    getResumeTindakan()
                }
            }
        })
    }

    function getResumeTindakan() {
        $('#tindakan-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("resume.tindakan") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tindakan.kode',
                    name: 'tindakan.kode'
                },
                {
                    data: 'tindakan.tindakan',
                    name: 'tindakan.tindakan'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    }

    $(function () {
        getResumeTindakan()

        $('#tindakan_id').select2({
            placeholder: 'Cari tindakan',
            multiple : false,
            ajax: {
                url: '/ajax/select2Tindakan',
                dataType: 'json',
                delay: 250,
                multiple: false,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.kode + ' - ' + item.tindakan,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#diagnosa-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("resume.diagnosa") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'diagnosa.kode',
                    name: 'diagnosa.kode'
                },
                {
                    data: 'diagnosa.nama',
                    name: 'diagnosa.nama'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        $('#resep-resume-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("resume.resep") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'obat.kode',
                    name: 'obat.kode'
                },
                {
                    data: 'obat.nama_obat',
                    name: 'obat.nama_obat'
                },
                {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });
    });
</script>

<script>
    $(document).ready(function () {

        $('.pilih-diagnosa').click(function () {
            var jenis_resume_id = $(this).data('id');
            var pendaftaran_id = "{{ $pendaftaran->id }}";
            var jenis = "diagnosa";
            $.ajax({
                url: '{{ route("resume.pilih-diagnosa") }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "jenis_resume_id": jenis_resume_id,
                    "pendaftaran_id": pendaftaran_id,
                    "jenis": jenis
                },
                beforeSend: function () {
                    $("#modalDiagnosa").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function (response) {
                    location.reload();
                }
            });
        });

        $('.pilih-obat').click(function () {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route("resume.pilih-resep") }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id,
                },
                beforeSend: function () {
                    $("#modalResep").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function (response) {
                    $("#modalLoading").modal('toggle');
                    $("#modalResepNext").modal('show');
                    $(".kode-obat").text(response.kode);
                    $("#data-jenis-resume-id").val(response.id);
                }
            });
        });

        $('.tambah-obat').click(function () {
            var pendaftaran_id = "{{ $pendaftaran->id }}";
            var jenis_resume_id = $("#data-jenis-resume-id").val();
            var jumlah = $("#jumlah-obat").val();
            var aturan_pakai = $("#aturan-pakai").val();
            var jenis = 'obat';

            if (jumlah == "" || aturan_pakai == "") {
                $("#modalAlert").modal('show');
            } else {

                $.ajax({
                    url: '{{ route("resume.tambah-resep") }}',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "jenis_resume_id": jenis_resume_id,
                        "pendaftaran_id": pendaftaran_id,
                        "jumlah": jumlah,
                        "keterangan": aturan_pakai,
                        "jenis": jenis
                    },
                    beforeSend: function () {
                        $("#modalResepNext").modal('toggle');
                        $("#modalLoading").modal('show');
                    },
                    success: function (response) {
                        location.reload();
                    }
                });
            }
        });

        $('.return-pilih-obat').click(function () {
            $('#modalResep').modal('show');
            $('#modalResepNext').modal('toggle');
        });

        $('.pilih-tindakan').click(function () {
            var jenis_resume_id = $(this).data('id');
            var pendaftaran_id = "{{ $pendaftaran->id }}";
            var jenis = "tindakan";
            $.ajax({
                url: '{{ route("resume.pilih-tindakan") }}',
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "jenis_resume_id": jenis_resume_id,
                    "pendaftaran_id": pendaftaran_id,
                    "jenis": jenis
                },
                beforeSend: function () {
                    $("#modalTindakan").modal('toggle');
                    $("#modalLoading").modal('show');
                },
                success: function (response) {
                    console.log(response)
                    // location.reload();
                }
            });
        });

    });

    $('#basic-datatables').DataTable({
        "scrollX": true
    });

    $('#basic-datatables-obat').DataTable({
        "scrollX": true
    });

    $('#basic-datatables-tindakan').DataTable({
        "scrollX": true
    });
</script>
@endpush

@push('css')
<link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<link href="{{asset('/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
<style>
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    table.dataTable {
        width: 100% !important;
    }
</style>
@endpush