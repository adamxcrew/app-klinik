<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nomor Rekamedis</th>
            <th>Nama Pasien</th>
            <th>Nama Tindakan</th>
            <th>Tarif Tindakan</th>
            <th>Poliklinik</th>
            <th>Perusahaan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($laporanTagihan as $laporan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ tgl_indo($laporan->tanggal) }}</td>
            <td>{{ $laporan->nomor_rekam_medis }}</td>
            <td>{{ $laporan->nama_pasien }}</td>
            <td>{{ $laporan->nama_tindakan }}</td>
            <td>{{ (rupiah($laporan->tarif_total)) }}</td>
            <td>{{ $laporan->poliklinik }}</td>
            <td>{{ $laporan->perusahaan_asuransi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>