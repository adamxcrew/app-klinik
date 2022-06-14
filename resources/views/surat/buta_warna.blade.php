<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sakit</title>
    <style>
    
    </style>
</head>

<body>

    @include('surat.kop_surat')
    <h4 style="text-align: center">PEMERIKSAAN BUTA WARNA</h4>
    <p>
        Yang bertanda tangan dibawah ini dokter Klinik Pratama Rawat Inap dr Nurdin Wahid menerangkan bahwa
    </p>
    <table>
        <tr>
            <td style="padding-right: 20px">Nama</td>
            <td>:</td>
            <th align="left"> {{ $nomorAntrian->pendaftaran->pasien->nama }}</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Tanggal Lahir, Usia</td>
            <td>:</td>
            <th align="left">{{ $nomorAntrian->pendaftaran->pasien->tanggal_lahir }}, {{ $nomorAntrian->pendaftaran->pasien->umur }} Tahun</th>
        </tr>
        <tr>
            <td style="padding-right: 20px">Alamat</td>
            <td>:</td>
            <th align="left">{{ $nomorAntrian->pendaftaran->pasien->alamat }}</th>
        </tr>
    </table>
    <p>Hasil Pemeriksaan Mata  :</p>


    <table>
        <tr valign="top">
            <td width="120">Pemeriksaan Penunjang</td>
            <td>
                <table>
                    <tr>
                        <td width="20"><input type="checkbox"></td>
                        <td>Buta Warna</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td>Tidak Buta Warna</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>Saran</td>
            <td> : .......................................................................................................................</td>
        </tr>
        <tr>
            <td>Diberikan Untuk Keperluan</td>
            <td> : .......................................................................................................................</td>
        </tr>
    </table>

    <p>Demikian surat keterangan ini kami buat dengan sebenarnya dan untuk digunakan sebagaimana mestinya .</p>
    <div style="float: right">
        <p style="margin-right:90px;margin-bottom:70px">Cibinong, {{ date('d M Y')}}<br>Dokter Pemeriksa</p>
        <br>
        <br>
        <br>
        <br>
        <br>

        Nama Dokter
    </div>

</body>

</html>