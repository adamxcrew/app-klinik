@extends('layouts.app')
@section('title','Approval Purchase Order')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <h1>Approval Purchase Order</h1>
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
                @include('alert')
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="purchase-order-table">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Kode PO</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    </table>
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
<script>
    $(function() {
        $('#purchase-order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/purchase-order',
            columns: [
                { data: 'detail', name: 'detail' },
                { data: 'kode', name: 'kode' },
                { data: 'tanggal', name: 'tanggal' },
                { data: 'supplier.nama_supplier', name: 'supplier.nama_supplier' },
                { data: 'status_po', name: 'status_po' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush
