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
            padding-bottom:40px;
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
            background-color: #31CE36;
            text-align: center;
            border-radius: 13px;
            width: 12px;
            height: 15px;
            font-size: 15px;
            color: #ffffff;
            font-weight: bold;
            padding: 5px 8px 8px 8px;
            display: inline-block;
            position: absolute;
            float: right;
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
        .status-antrian{
            background: greenyellow;
            padding: 5px;
            border-radius: 7px;
            display: inline-block;
            position: absolute;
            height: 16px;
            float: right;
            top: -8px
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
                <label class="nomor-antrian">3</label>
            </div>
        </div>

        <div class="content-body">

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Nama Pasien</span><br>
                    <small class="text-small">Pasien detail</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">Wahyu Safrizal</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Nomo Pendaftaran</span><br>
                    <small class="text-small">Pendaftaran</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">PS-20210911- </span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Poliklinik</span><br>
                    <small class="text-small">Bagian</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">UMUM</span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Nama Dokter</span><br>
                    <small class="text-small">Dokter</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info">dr. Resti Amalia </span>
                </div>
            </div>

            <div class="content-spac">
                <div class="text-left">
                    <span class="text-left-info">Status Antrian</span><br>
                    <small class="text-small">Status</small>
                </div>
                <div class="text-right">
                    <span class="text-right-info status-antrian">Mengantri untuk diagnosa </span>
                </div>
            </div>

            <div class="content-spac" style="padding-top:20px">
                <div class="text-left">
                    <span class="text-left-info">Tanggal Pendaftaran</span><br>
                </div>
                <div class="text-right">
                    <span class="text-right-info">{{ date('d-m-Y') }}</span>
                </div>
            </div>

        </div>
    </div>
</body>
</html>