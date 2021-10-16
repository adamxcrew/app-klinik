@extends('layouts.app')
@section('title','Kelola Tindakan')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>
        Laporan Fee Tindakan
        <small>Daftar Fee Tindakan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Fee Tindakan</li>
      </ol>
    </section>


    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="col-md-12" style="margin: 1% 0">
                <a href="/laporan-fee-tindakan/export_excel" class="btn btn-success pull-right"> <i class="fa fa-table"></i> Export Excel</a>
                <div class="col-md-3">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="filterDate">
                  </div>
                </div>
              </div>
              <div class="box-body">
                @include('alert')
                <table class="table table-bordered table-striped" id="fees-table">
                  <thead>
                      <tr>
                        <th width="10">Nomor</th>
                        <th>Tanggal</th>
                        <th>Unit</th>
                        <th>Pelaksana</th>
                        <th>Nama Pelaksana</th>
                        <th>Nama Tindakan</th>
                        <th>Tarif Tindakan</th>
                        <th>Nomor Pendaftaran</th>
                        <th>Jenis Pelayanan</th>
                      </tr>
                  </thead>
              </table>
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
<!-- date-range-picker -->
<script src="{{asset('adminlte/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script>
    $(function () {
		const feeDatatable = $('#fees-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: {
				url : '/laporan-fee-tindakan',
				data : {
					startDate : ()=>{
						let date = $('#filterDate').val()
						date = date.split(" ")

						return date[0]
					},
					endDate : ()=>{
						let date = $('#filterDate').val()
						date = date.split(" ")

						return date[2]
					}
				}
			},
			columns: [
				{ data: 'DT_RowIndex', orderable: false, searchable: false },
				{ data: 'tanggal', name: 'tanggal' },
				{ data: 'unit', name: 'unit' },
				{ data: 'pelaksana', name: 'pelaksana' },
				{ data: 'nama_pelaksana', name: 'nama_pelaksana' },
				{ data: 'nama_tindakan', name: 'nama_tindakan' },
				{ data: 'jumlah_fee', name: 'jumlah_fee' },
				{ data: 'nomor_pendaftaran', name: 'nomor_pendaftaran' },
				{ data: 'jenis_pelayanan', name: 'jenis_pelayanan' },
			]
		});

        $('#filterDate').daterangepicker({}, function (start, end) {
                $('#filterDate span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
                startDate = start;
                endDate = end;
            }
		)

        $('#filterDate').on('apply.daterangepicker', function (ev, picker) {
            feeDatatable.ajax.reload()
        });
    }); 
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
@endpush
