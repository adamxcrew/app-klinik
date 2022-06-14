<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sakit</title>
</head>

<body>

    @include('surat.kop_surat')
    <h4 style="text-align: center">SURAT RUJUKAN</h4>

    <div class="mt-3">
        <table>
            <tr>
                <td width="130">Nama</td>
                <td>:</td>
                <td align="left"> {{ $nomorAntrian->pendaftaran->pasien->nama }}</td>
            </tr>
            <tr>
                <td width="120">Tanggal Lahir, Usia</td>
                <td>:</td>
                <td align="left">{{ $nomorAntrian->pendaftaran->pasien->tanggal_lahir }}, 10 Tahun</td>
            </tr>
            <tr>
                <td width="120">Jenis Kelamin</td>
                <td>:</td>
                <td align="left"> {{ $nomorAntrian->pendaftaran->pasien->jenis_kelamin=='pria'?'Laki Laki':'Perempuan' }}</td>
            </tr>
            <tr>
                <td width="120">Alamat</td>
                <td>:</td>
                <td align="left">{{ $nomorAntrian->pendaftaran->pasien->alamat }}</td>
            </tr>
        </table>
        Dengan hasil pemeriksaan sebagai berikut : 
        <table>
            <tr>
                <td width="130">Anamnesa</td>
                <td>:</td>
                <td align="left">{{ $nomorAntrian->pendaftaran->anamnesa }}</td>
            </tr>
        </table>
        <p>Pada pemeriksaan yang kami lakukan secara fisik diagnostik kami menerangkan : </p>


        <table>
            <tr>
                <td width="120">1. Kesadaran</td>
                <td>:</td>
                <td width="120" align="left"> ...... mmHg</td>
                <td width="120">5. RR</td>
                <td>:</td>
                <td align="left"> ...... mmHg</td>
            </tr>
            <tr>
                <td width="120">2. TD</td>
                <td>:</td>
                <td align="left"> ...... x/Menit </td>
                <td width="120">6. Sp02</td>
                <td>:</td>
                <td align="left"> ...... mmHg</td>
            </tr>
            <tr>
                <td width="120">3. Nadi</td>
                <td>:</td>
                <td align="left"> ...... Kg</td>
                <td width="120">7. Suhu</td>
                <td>:</td>
                <td align="left"> ...... Celcius</td>
            </tr>
            <tr>
                <td width="120">4. Lain Lain</td>
                <td>:</td>
                <td align="left"></td>
            </tr>
        </table>
        <table>
            <tr valign="top">
                <td width="120">Pemeriksaan Penunjang</td>
                <td>
                    <table>
                        <tr>
                            <td width="20"><input type="checkbox"></td>
                            <td>Laboratorium</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Radiologi</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Lainya : </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Diagnosa Sementara</td>
                <td> : .......................................................................................................................</td>
            </tr>
            <tr>
                <td>Tindakan Yang Diberikan</td>
                <td> : .......................................................................................................................</td>
            </tr>
            <tr>
                <td>Terapi Yang Diberikan</td>
                <td> : .......................................................................................................................</td>
            </tr>
        </table>

        <p>Atas kerjasamanya terima kasih .</p>
        <div style="float: right">
            <p style="margin-right:90px;margin-bottom:70px">Cibinong, {{ date('d M Y')}}<br>Dokter Pemeriksa</p>
            <br>
            <br>
            <br>
            <br>
            <br>

            Nama Dokter
        </div>
    </div>

</body>

</html>