<style>
    body{
        font-size:16px;
    }
    .pembatas{
        /* border: 1px solid black; */
        padding:0px;
        width: 320px;
        float: left;
        margin-left:-30px;
        text-transform: uppercase;
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

    <p>Sample Text Sample Text Sample</p>
    <p>2 x 1 diminum sesudah makan</p>
</div>

@endforeach
