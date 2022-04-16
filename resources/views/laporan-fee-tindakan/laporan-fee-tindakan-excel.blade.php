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
                <td>{{tgl_indo($row->created_at)}}</td>
                <td>{{$row->unit->nama??'-'}}</td>
                <td>{{$row->pelaksana}}</td>
                <td>{{$row->user->nama}}</td>
                <td>{{$row->tindakan->tindakan}}</td>
                <td>{{convert_rupiah($row->jumlah_fee)}}</td>
                <td>{{$row->pendaftaran->kode}}</td>
                <td>{{$row->pendaftaran->perusahaanAsuransi->nama_perusahaan}}</td>
            </tr>
        @endforeach
    </tbody>
</table>