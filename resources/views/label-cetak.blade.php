<style>
    body{
        font-size:12px;
    }
    .pembatas{
        border: 1px solid black;
        padding:10px;
        width: 200px;
        float: left;
        margin-right:20px;
    }
</style>

<?php 
$no=1;
?>
@foreach ($obatRacik as $item)
<div class="pembatas">
    <h3>{{ $setting->nama_instansi }} {{ $setting->nomor_telpon }}</h3>
    <p>
        Apoteker : {{ Auth::user()->name }}
    </p>
    <h3>{{ $pendaftaran->pasien->nomor_rekam_medis}} - {{ $pendaftaran->pasien->nama}} </h3>
    <p>{{ date("d/m/Y", strtotime($pendaftaran->pasien->tanggal_lahir))}} </p>
</div>
@if($no==3)
<hr>
@endif
<?php $no++;?>
@endforeach
