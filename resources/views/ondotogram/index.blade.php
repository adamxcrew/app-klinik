@extends('layouts.app')
@section('title','Kelola Data Ondotogram')
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Kelola Data Ondotogram
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
            <a href="{{route('akun.create')}}" class="btn btn-info btn-social btn-flat"><i class="fa fa-plus-square-o" aria-hidden="true"></i>
              Tambah Data</a>
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                Launch Default Modal
              </button>
            <hr>
            <img src="https://infodrg.com/wp-content/uploads/2020/12/1206D6AF-6FA6-41C5-A2F5-D49B1D86622A.jpeg" width="100%" alt="">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>NOMOR</th>
                    <th>GIGI</th>
                    <th>Kondisi</th>
                    <th>Anamnesa</th>
                    <th>Tindakan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Default Modal</h4>
      </div>
      <form action="#">
        <input type="hidden" id="pendaftaranId" class="form-control" value="{{ $pendaftaranId }}">
        <div class="modal-body">
          <div class="row">
              <div class="col-md-4">
                <label for="">Kondisi / Pemeriksaan</label>
              </div>
              <div class="col-md-8">
                  <div class="form-group">
                    <select name="tbm_icd_id" id="tbm" class="tbm-icd form-control" style="height: 100px;width: 100%" placeholder="Masukan Nama Tbm"></select>
                  </div>
              </div>
              <div class="col-md-4">
                <label for="">Anamnesa</label>
              </div>
              <div class="col-md-8">
                  <div class="form-group">
                      <input type="text" id="anamnesa" class="form-control" placeholder="Masukan anamnesa">
                  </div>
              </div>
              <div class="col-md-4">
                <label for="">Tindakan</label>
              </div>
              <div class="col-md-8">
                  <div class="form-group">
                    <input type="text" id="tindakan" class="form-control" placeholder="Masukan tindakan">
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="button" id="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@push('scripts')
<script src="{{asset('adminlte/bower_components/select2/dist/js/select2.min.js')}}"></script>
<script>
$( document ).ready(function() {
    $('.tbm-icd').select2({
        placeholder: 'Cari Nama Tbm',
        ajax: {
        url: '/ajax/select2TBM',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
            results:  $.map(data, function (item) {
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

    $('#submit').on('click', function() {
    let tbm_icd_id = $('#tbm').val()
    let anamnesa = $('#anamnesa').val()
    let tindakan = $('#tindakan').val()
    let pendaftaran_id = $('#pendaftaranId').val()
    payload = {
      "_token": "{{ csrf_token() }}",
      tbm_icd_id,
      anamnesa,
      tindakan,
      pendaftaran_id
    }
    $.ajax({
      method: 'POST',
      url: '/ondotogram',
      data: payload,
      success: function(res) {
        console.log(res);
        $('#valAnamnesa').html(res.data.anamnesa)
        $('#modal-default').modal('toggle')
      }
    })
    })
});
</script>
@endpush

@push('css')
    <link href="{{asset('adminlte/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
@endpush