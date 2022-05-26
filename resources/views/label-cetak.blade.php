<style>
    body{
        font-size:11px;
    }
    .pembatas{
      
    
        width: 200%;
        margin-left:-30px;
        margin-top:-50px;
        margin-bottom:-50px;
        text-transform: uppercase;
        page-break-after:always;
    }
</style>

@foreach ($dataCetak as $item)
<div class="pembatas">
    <p>
        <b>{{ $setting->nama_instansi }} ( {{ $setting->nomor_telpon }} )</b><br>
        Apoteker : {{ Auth::user()->name }}<br>
        SIPA : 1234567890/ 123456789<br>
        {{ $pendaftaran->pasien->nomor_rekam_medis}} - <b>{{ $pendaftaran->pasien->nama}}</b>
        <br>
    <b>{{ date("d/m/Y", strtotime($pendaftaran->pasien->tanggal_lahir))}}</b><br>
    {{ $pendaftaran->kode }}  {{ date('d/m/Y H:i')}} <br>ED : <br>
    Sample Nama Obat 100 ML<br>
    2 x 1 diminum sesudah makan
    </p>
</div>

@endforeach
