<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Keterangan Sakit</title>
    <style>
        .text-center {
            text-align: center;
        } 
        .mt-3 {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1 class="text-center"><u>Surat Keterangan Sakit</u></h1>

    <div class="mt-3">
        <p>Yang bertanda tangan dibawah ini memberitahukan bahwa :</p>
        <div style="margin-left: 50px;">
            <table>
                <tr>
                    <td style="padding-right: 20px">Nama</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->nama }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Jenis Kelamin</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->jenis_kelamin) }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Pekerjaan</td>
                    <td >:</td>
                    <th align="left">{{ $surat->pasien->pekerjaan }}</th>
                </tr>   
                <tr>
                    <td style="padding-right: 20px">Alamat</td>
                    <td >:</td>
                    <th align="left">{{ ucfirst($surat->pasien->alamat) }}</th>
                </tr>   
            </table>
        </div>
        <p>Perlu beristirahat karena sakit selama <b>{{ $surat->selama }}</b> terhitung mulai dari tanggal</p>
        <p><b>{{ date('d F Y', strtotime($surat->tanggal_mulai)) }}</b> s.d tanggal <b>{{ date('d F Y', strtotime($surat->tanggal_selesai)) }}.</b></p>
        <p>Demikian surat keterangan ini diberikan untuk diketahui dan dipergunakan</p>
        <p>seperlunya.</p>
        <div style="float: right">
            <p>Bogor, .................</p>
            <p style="margin-left:35px px;margin-bottom:70px">Dokter,</p>
            <p >{{ $surat->user->name }}</p>
        </div>
    </div>
    
</body>
</html>