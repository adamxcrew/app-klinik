<style>
    *{
        font-family: 'Arial';
        font-size : 10pt;
    }

    .const{
        margin : 3% 0% 3% 8%;
    }

    table{
        width : 90%;
    }

    .const .centered-table {
        text-align :center !important;
    }

    .centered-table td{
        padding:2px
    }

</style>
<div>
    @include('surat.kop_surat')
    <div style="float:left;margin-top:5%;margin-left:5%;">
        <strong>HASIL PEMERIKSAAN LABORATORIUM</strong>
    </div>
</div>
<div style="clear:both">

</div>
<hr style="margin:0% 5%">
<div style="width:100%">
    <div class="const">
        <table style="margin-bottom:25px;">
            <tr style="background-color : #EEEEEE">
                <th colspan=2 style="text-align:left;width:40%">Dokter</th>
                <th colspan=2 style="text-align:left">Pasien</th>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: {{$nomorAntrian->dokter->name}}</td>
                <td>Nama</td>
                <td>: {{$nomorAntrian->pendaftaran->pasien->nama}}</td>
            </tr>
            <tr style="background-color : #EEEEEE">
                <td></td>
                <td></td>
                <td style="vertical-align:top">Alamat</td>
                <td>: {{$nomorAntrian->pendaftaran->pasien->alamat}} </td>
            </tr>
            <tr>
                <td>Pembayaran</td>
                <td>: Tunai</td>
                <td>Jenis Kelamin</td>
                <td>: {{ucWords ($nomorAntrian->pendaftaran->pasien->jenis_kelamin)}}</td>
            </tr>
            <tr style="background-color : #EEEEEE">
                <td></td>
                <td></td>
                <td>Umur</td>
                <td>: {{$nomorAntrian->pendaftaran->pasien->tanggal_lahir}}</td>
            </tr>
            <tr>
                <td>Tanggal, Jam</td>
                <td>: {{date('d F Y - h:i', strtotime(now()))}}</td>
                <td>No. Lab / RM</td>
                <td>: -</td>
            </tr>
        </table>

        <table>
            @foreach($tindakanLab as $tindakan)
            <tr>
                <td colspan="4">Pemeriksaan : {{ $tindakan->tindakan->tindakan}}</td>
            </tr>
            <tr style="color:white;background-color:#C85C5C;padding:16px 0">
                <th width="20">No</th>
                <th>Parameter</th>
                <th>Satuan</th>
                <th>Hasil</th>
                <th>Nilai Normal</th>
            </tr>
            @foreach(\App\Models\HasilPemeriksaanLab::where('pendaftaran_id',$nomorAntrian->pendaftaran_id)->where('tindakan_id',$tindakan->tindakan->id)->get() as $hasil)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $hasil->indikator->nama_indikator}}</td>
                <td>{{ $hasil->indikator->satuan}}</td>
                <td>{{ $hasil->hasil}}</td>
                <td>{{ $hasil->indikator->nilai_rujukan}}</td>
            </tr>                
            @endforeach
            @endforeach
        </table>

        <div style="border-top : dashed 1px #C85C5C; width:86%;
            margin:2%;margin-bottom:100px;padding-top:10px">
            Catatan :
        </div>
        <div style=" text-align:center;
            width:150px;height:150px;
            
            font-size:10pt;float:right;margin-right:15%">
            Analisis Laboratorium
            <br> <br> <br> <br> <br> <br> <br> <br> <br>
            {{ Auth::user()->name}}
        </div>
        {{-- <div style="
            margin-bottom:50px;
            border-top:solid 2px #3C2C3E;
            width:90%;text-align:center;
            border:1px solid black;
            position: fixed;
            bottom: 40;">
            Jl. Hm. Ashari No.22 Cibinong – Bogor 16911, Telpon : ( 021 ) 8791 6739
            <br>
            <table width=90 style="text-align:center">
                <tr>
                    <td>
                        <img src="{{public_path('image/fb.png')}}" alt="facebook" width=20px>
                    </td>
                    <td>klinik dr.nurdin wahid</td>
                    <td>
                        <img src="{{public_path('image/ig.png')}}" alt="instagram" width=20px>
                    </td>
                    <td>klinikdr.nurdin</td>
                    <td>
                        <img src="{{public_path('image/twitter.png')}}" alt="twitter" width=20px>
                    </td>
                    <td>klinik dr.nurdin wahid</td>
                    <td>
                        <img src="{{public_path('image/youtube.png')}}" alt="youtube" width=20px>
                    </td>
                    <td>klinik dr.nurdin wahid</td>
                </tr>
            </table> --}}
        </div>
    </div>
</div>
