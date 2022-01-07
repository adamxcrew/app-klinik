<table>
    <tr>
        <th>Tanggal</th>
        <th>Nomor Rekamedis</th>
        <th>Nama</th>
        <th>Poliklinik</th>
        <th>Jenis Asuransi</th>
    </tr>
    @foreach($laporan as $row)
        <tr>
            <td>{{ substr($row->created_at,0,10) }}</td>
            <td>{{ $row->pasien->nomor_rekam_medis }}</td>
            <td>{{ $row->pasien->nama }}</td>
            <td>{{ $row->poliklinik->nama }}</td>
            <td>{{ $row->perusahaanAsuransi->nama_perusahaan }}</td>
        </tr>
    @endforeach
</table>

