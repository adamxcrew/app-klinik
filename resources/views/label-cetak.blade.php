<style>
    body{
        font-size:14px;
    }
    .pembatas{
        border: 1px solid black;
        padding:10px;
        width: 230px;
        float: left;
        margin-left:-30px;
        page-break-after:always;
    }
</style>

@foreach ($dataCetak as $item)
<div class="pembatas">
    <h3>{{ $setting->nama_instansi }} ( {{ $setting->nomor_telpon }} )</h3>
    <p>
        Apoteker : {{ Auth::user()->name }}<br>
        SIPA : 1234567890/ 123456789
    </p>
    <p>{{ $pendaftaran->pasien->nomor_rekam_medis}} - {{ $pendaftaran->pasien->nama}} <br>
    {{ date("d/m/Y", strtotime($pendaftaran->pasien->tanggal_lahir))}} </p>

    <p>Sample Text Sample Text Sample Text</p>
    <p>Sample Text Sample Text Sample Text</p>
</div>

@endforeach
