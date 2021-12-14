<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kode Pendaftaran</th>
            <th>Nomor RM</th>
            <th>Nama Pasien</th>
            <th>Jenis Layanan</th>
            <th>Total Transaksi</th>
            <th>Jenis Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @php 
            $total = null;
            $total_looping = $jumlah_pendaftaran - $laporan_transaksi->count()
        @endphp
        
        @foreach($laporan_transaksi as $laporan)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ tgl_indo(substr($laporan->created_at, 0, 10)) }}</td>
            <td>{{ $laporan->kode }}</td>
            <td>{{ $laporan->pasien->nomor_rekam_medis }}</td>
            <td>{{ $laporan->pasien->nama }}</td>
            <td>{{ $laporan->perusahaanAsuransi->nama_perusahaan }}</td>
            <td>{{ convert_rupiah($laporan->total_bayar) }}</td>
            <td>{{ $laporan->metode_pembayaran }}</td>
        </tr>
        @php 
            $total += $laporan->total_bayar;
        @endphp
        @endforeach

        @for($i=0;$i<=$total_looping;$i++)
            <tr></tr>
        @endfor
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>TOTAL</th>
            <th>{{ convert_rupiah($total) }}</th>
        </tr>
    </tbody>
</table>