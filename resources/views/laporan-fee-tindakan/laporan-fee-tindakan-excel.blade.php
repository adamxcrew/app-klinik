<table class="table table-bordered table-striped" id="users-table">
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
    <tbody>
        @foreach($fees as $row)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$row->tanggal}}</td>
                <td>{{$row->unit??'-'}}</td>
                <td>{{$row->pelaksana}}</td>
                <td>{{$row->nama_pelaksana}}</td>
                <td>{{$row->nama_tindakan}}</td>
                <td>{{$row->jumlah_fee}}</td>
                <td>{{$row->nomor_pendaftaran}}</td>
                <td>{{$row->jenis_pelayanan}}</td>
            </tr>
        @endforeach
    </tbody>
</table>