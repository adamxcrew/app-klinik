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
        .dotted {
            border-bottom: 1px dotted black
        }
    </style>
</head>
<body style="padding:10px">

    <div>
        <table>
            <tr>
                <td><img src="https://alumniphb.net/upload/loker//download_(3)1.png" alt=""></td>
                <td>
                    <h3>KLINIK DR. NURDIN WAHID</h3>
                    <p style="margin: -13px 0">Jl. HM. Ashari no.22 Cibinong-Bogor</p>
                    <p>Telp. 021 87916739</p>
                </td>
            </tr>
        </table>
    </div>
    <hr style="border: 1px dotted black">
    <h4 class="text-center">BUKTI PEMBAYARAN</h4>

    <div>
        <table border="0">
            <tr>
                <td>RM / Nama Pasien</td>
                <td width="2px">:</td>
                <td>{{ $pendaftaran->pasien->nomor_rekam_medis }} / {{ $pendaftaran->pasien->inisial }} {{ $pendaftaran->pasien->nama }}</td>
                <td width="25px">&nbsp;</td>
                <td>Tanggal Kunjungan</td>
                <td width="2px">:</td>
                <td>{{ tgl_indo(substr($pendaftaran->created_at, 0, 10)) }}</td>
            </tr>
            <tr>
                <td>Penjamin</td>
                <td>:</td>
                <td>{{ $pendaftaran->perusahaanAsuransi->nama_perusahaan }}</td>
            </tr>
        </table>
    </div>

    {{-- <hr style="width: 100%; border: 1px dotted black"> --}}

    <div style="margin: 30px 0">
        <table style="width: 100%;border-top: 1px dotted black">
            <thead class="dotted">
                <tr>
                    <th>NO</th>
                    <th>KETERANGAN</th>
                    <th>QTY</th>
                    <th width="70">TARIF</th>
                    <th>DISC</th>
                    <th>TAGIHAN PENJAMIN</th>
                    <th>TAGIHAN PASIEN</th>
                </tr>
            </thead>
            @php
                $total = 0;
            @endphp
            @foreach($tindakans as $tindakan)
            <tbody class="dotted" style="text-align:center">
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tindakan->tindakan->tindakan }} - {{ $tindakan->pendaftaran->dokter->name }}</td>
                    <td>-</td>
                    <td>{{ convert_rupiah($tindakan->fee) }}</td>
                    <td>-</td>
                    <td>{{ ($penjamin == 'UMUM') ? '-' : (($penjamin == 'BPJS') ? convert_rupiah($tindakan->fee) : convert_rupiah($tindakan->fee)) }}</td>
                    <td>{{ $penjamin == 'UMUM' ? convert_rupiah($tindakan->fee) : '-' }}</td>
                </tr>
                @php
                    if($penjamin == 'UMUM') {
                        $total += $tindakan->fee;
                    } else if($penjamin == 'BPJS') {
                        $total += $tindakan->fee;
                    } else {
                        $total += $tindakan->fee;
                    }
                @endphp
                {{-- <tr>
                    <td>1</td>
                    <td>
                        <div>
                            <strong><i>TINDAKAN POLI KEBIDANAN - dr. Win Irwan,SpOG</i></strong>
                        </div>
                        <div>USG 2D ( Dr. Win, SpOG )</div>
                    </td>
                    <td>1</td>
                    <td>170.000.00</td>
                    <td>0,00</td>
                    <td>0,00</td>
                    <td>170.000.00</td>
                </tr> --}}
            </tbody>
            @endforeach
            <tbody class="dotted" style="text-align: center">
                <tr>
                    <td></td>
                    <td>TOTAL</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $penjamin != 'UMUM' ? convert_rupiah($total) : '-' }}</td>
                    <td>{{ $penjamin == 'UMUM' ? convert_rupiah($total) : '-' }}</td>
                </tr>
            </tbody>
            <tbody class="dotted" style="text-align: center">
                <tr>
                    <td></td>
                    <td width="300px">TOTAL YANG HARUS DIBAYAR PASIEN</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $penjamin == 'UMUM' ? convert_rupiah($total) : '-' }}</td>
                </tr>
            </tbody>
            <tbody class="dotted">
                <tr>
                    <td></td>
                    <td width="300px"><i>TERBILANG #{{ strtoupper(terbilang($total)) }}#</i></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        <div style="float: right">
            <p style="margin-bottom:60px;padding-left:30px">Kasir</p>
            <p style="margin-bottom:-10px;margin-left:30px"><strong>{{ Auth::user()->name }}</strong></p>
            <p style="">Dokter Pemeriksa</p>
        </div>
    </div>
    
</body>
</html>