<style>
    body{
        font-size:12px;
    }
    .pembatas{
        border: 1px solid black;
        padding:10px;
        width: 230px;
    }
</style>


<div class="pembatas">
<h3>{{ $setting->nama_instansi }} {{ $setting->nomor_telpon }}</h3>
<p>
    Apoteker : Nama Apoteker
</p>
<h3>{{ $pendaftaran->pasien->nomor_rekam_medis}} - {{ $pendaftaran->pasien->nama}} </h3>
<p>{{ date("d/m/Y", strtotime($pendaftaran->pasien->tanggal_lahir))}} </p>
</div>