@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <table class="table table-bordered" id="users-table">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Obat</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th width="60">#</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/obat',
            columns: [
                { data: 'kode', name: 'kode' },
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'satuan.satuan', name: 'satuan.satuan' },
                { data: 'harga', name: 'harga' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action' }
            ]
        });
    });
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endpush
