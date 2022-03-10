<table class="table table-bordered">
    <tr>
        <th width="10">No</th>
        <th>Dokter Perujuk</th>
        <th>Nama Unit</th>
        <th>Jenis Pemeriksaan</th>
        <th>Status</th>
        <th width="30"></th>
    </tr>
    @if($rujukanInternal->count() < 1)
    <tr>
        <td colspan="5">Belum Ada Data</td>
    </tr>
    @else
        @foreach($rujukanInternal->get() as $row)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $row->dokter->name}}</td>
            <td>{{ $row->poliklinik->nama }}</td>
            <td>{{ $row->tindakan->tindakan }}</td>
            <td>{{ $row->status }}</td>
            <td><button onClick="hapus_rujukan({{$row->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
        @endforeach
    @endif
</table>