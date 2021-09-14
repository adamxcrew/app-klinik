<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .content{
            width: 50%;
            border: 1px solid black;
            border-style: dashed;
            padding:5px
        }
        .content-header{
            border-bottom: 1px solid black;
            padding-bottom:20px;
            padding-top:10px
        }
        .content-body{
            padding-top: 10px;
        }
        .header-left{
            text-align: left;
            width: 50%;
            font-weight: bold;
        }
        .header-right{
            text-align: right;
            width: 100%;
            margin-top: -19px;
        }
        .nomor-antrian{
            font-size: 15px;
            color: black;
            font-weight: bold;
        }
        .text-right{
            text-align: right;
            margin-top: -20px;
        }
        .text-small{
            font-size:10px
        }
        .text-right-info{
            font-size:14px;
        }
        .text-left-info{
            font-size: 14px;
            font-weight: bold;
        }
        .content-spac{
            padding-bottom: 20px;
        }
    </style>
</head>
<body style="font-family: 'sans-serif;">
    <div class="content">
        <div class="content-header">
            <div class="header-left">
                <span>Nomor Antrian</span>
            </div>
            <div class="header-right">
                <label class="nomor-antrian">{{ substr($pasien->kode,11, 5) }}</label>
            </div>
        </div>

        <div class="content-body">

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Nama Pasien</span><br>
                    <small class="text-small">Pasien detail</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ $pasien->pasien->nama }}</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Nomo Pendaftaran</span><br>
                    <small class="text-small">Pendaftaran</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ $pasien->kode }}</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Poliklinik</span><br>
                    <small class="text-small">Bagian</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ $pasien->poliklinik->nama }}</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Nama Dokter</span><br>
                    <small class="text-small">Dokter</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ $pasien->dokter->name }}</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Jenis Layanan</span><br>
                    <small class="text-small">Jenis</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ $pasien->jenis_layanan }}</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Tanggal Pendaftaran</span><br>
                    <small class="text-small">tanggal</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ substr($pasien->created_at, 0 ,10) }}</span>
                </div>
            </div>

        </div>
    </div>
</body>
</html>