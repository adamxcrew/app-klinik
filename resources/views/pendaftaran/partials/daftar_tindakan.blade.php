<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        <th width="90">Kode ICD 9</th>
        <th>Nama Tindakan</th>
        <th width="50">Fee</th>
        <th width="30"></th>
    </tr>
    @if($pendaftaranTindakan->count() < 1)
    <tr>
        <td colspan="5">Belum Ada Data</td>
    </tr>
    @else
        @foreach($pendaftaranTindakan->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->tindakan->icd->code }}</td>
            <td>{{ $row->tindakan->tindakan }}</td>
            <td>{{ $row->fee }}</td>
            <td><button onClick="hapus_daftar_tindakan({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>