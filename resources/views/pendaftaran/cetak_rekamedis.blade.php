<style>
    body{
        font-size: 13px;
    }
    .table, .td, .th {
    border: 1px solid;
    text-align: left;
    padding:5px;
    }

    .table {
    width: 100%;
    border-collapse: collapse;
}
</style>

<div>
    <table>
        <tr>
            <td><img src="https://alumniphb.net/upload/loker//download_(3)1.png" alt=""></td>
            <td>
                <h3>KLINIK DR. NURDIN WAHID</h3>
                <p style="margin: -13px 0">Jl. HM. Ashari no.22 Cibinong-Bogor</p>
                <p>Telp. 021 87916739</p>
            </td>
        </tr>
    </table>
</div>
<hr>


<table>
    <tr>
        <td width="80">No RM</td>
        <td width="150"> : {{ $pendaftaran->pasien->nomor_rekam_medis}}</td>
        <td width="80">Alamat</td>
        <td width="150"> : {{ $pendaftaran->pasien->alamat }}</td>
    </tr>
    <tr>
        <td width="100">Nama</td>
        <td> : {{ $pendaftaran->pasien->nama }}</td>
        <td>No Telpon</td>
        <td> : {{ $pendaftaran->pasien->nomor_hp }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td> : {{ ucfirst($pendaftaran->pasien->jenis_kelamin) }}</td>
        <td>Riwayat Penyakit</td>
        <td> : -</td>
    </tr>
    <tr>
        <td>TTL</td>
        <td> : {{ $pendaftaran->pasien->tempat_lahir.', '. tgl_indo($pendaftaran->pasien->tanggal_lahir) }}</td>
        <td>Alergi Obat</td>
        <td> : -</td>
    </tr>
</table>

<br><br>



<table class="table">
    <tr>
        <th class="th">Tanggal</th>
        <th class="th">Anamnesa</th>
        <th class="th">Diagnosa</th>
        <th class="th">Keterangan</th>
    </tr>
    @foreach($riwayatKunjungan as $riwayat)
    <tr>
        <td class="td">{{ tgl_indo(substr($riwayat->created_at,0,10)) }}</td>
        <td class="td">{{ $riwayat->anamnesa }}</td>
        <td class="td">Diagnosa</td>
        <td class="td">Keterangan</td>
    </tr>
    @endforeach
</table>