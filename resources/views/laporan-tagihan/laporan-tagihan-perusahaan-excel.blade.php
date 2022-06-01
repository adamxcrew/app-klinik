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
            <td>{{ tgl_indo(substr($laporan->created_at, 0, 10)) }}</td>
            <td>{{ $laporan->pendaftaran->pasien->nomor_rekam_medis }}</td>
            <td>{{ $laporan->pendaftaran->pasien->nama }}</td>
            <td>{{ $laporan->tindakan->tindakan }}</td>
            <td>{{ ($laporan->pendaftaran->perusahaanAsuransi->nama_perusahaan == 'UMUM') ? convert_rupiah($laporan->tindakan->tarif_umum) : 
                    (($laporan->pendaftaran->perusahaanAsuransi->nama_perusahaan == 'BPJS') ? convert_rupiah($laporan->tindakan->tarif_bpjs) : 
                    convert_rupiah($laporan->tindakan->tarif_perusahaan)) }}</td>
            <td>{{ $laporan->pendaftaran->dokter->name }}</td>
            <td>{{ $laporan->pendaftaran->poliklinik->nama }}</td>
            <td>{{ $laporan->pendaftaran->perusahaanAsuransi->nama_perusahaan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>