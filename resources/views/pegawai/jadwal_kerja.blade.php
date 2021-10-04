
<table class="table table-bordered table-striped">
    <tr>
        <td>Pilih Periode</td>
        <td>
            {!! Form::select('periode', ['2020-10'=>'Oktober 2020'], null, ['class'=>'form-control']) !!}
        </td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button type="submit" class="btn btn-danger">Tampilkan</button>
        </td>
    </tr>
</table>
<hr>
<a href="{{ url("pegawai/atur-jadwal?pegawai=$pegawai->id") }}" class="btn btn-primary" style="margin-bottom:20px">Atur Waktu Kerja</a>
<table class="table table-bordered table-striped" id="myTable">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Shift Kerja</th>
        </tr>
    </thead>
    <tbody>
        @for($i=1;$i<=30;$i++)
        <tr>
            <td>
                {!! Form::date('tanggal', '2021-10-'.$i, ['class'=>'form-control']) !!}
            </td>
            <td>
                {!! Form::select('shift_id',['1'=>'Shift 1'], null, ['class'=>'form-control','Placeholder'=>'shift']) !!}
            </td>
        </tr>
        @endfor
    </tbody>
</table>
@push('scripts')
<script src="{{asset('adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
$(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{asset('adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush