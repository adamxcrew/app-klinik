<?php

function generateUniqNumber($table, $field, $prefix)
{
    $latestValue = \DB::table($table)->max($field);
    if ($latestValue == null) {
        return $prefix . '0001';
    } else {
        $noUrut = (int) substr($latestValue, 3, 3) + 1;
        return $prefix . sprintf("%03s", $noUrut);
    }
}


function generateKodePendaftaran()
{
    $latestValue = \DB::table('pendaftaran')->max('kode');
    if ($latestValue == null) {
        return 'PD-' . date('Ymd') . '0001';
    } else {
        $noUrut = (int) substr($latestValue, 11, 5) + 1;
        return 'PD-' . date('Ymd') . sprintf("%04s", $noUrut);
    }
}

function generateKodeRekamMedis()
{
    $latestValue = \DB::table('pasien')->max('nomor_rekam_medis');
    if ($latestValue == null) {
        return 'NMC-00000001';
    } else {
        $noUrut = (int) substr($latestValue, 4, 8) + 1;
        return 'NMC-' . sprintf("%08s", $noUrut);
    }
}

function generateKodePurchaseOrder()
{
    $latestValue = \DB::table('purchase_order')->max('kode');
    if ($latestValue == null) {
        return 'PO-00000001';
    } else {
        $noUrut = (int) substr($latestValue, 4, 8) + 1;
        return 'PO-' . sprintf("%08s", $noUrut);
    }
}

function hitung_umur($date)
{
    $sekarang      = Carbon\Carbon::now();
    $tanggal_lahir = Carbon\Carbon::parse($date);
    $umur = $tanggal_lahir->diffInYears($sekarang);

    return $umur;
}

function convert_rupiah($value)
{
    return "Rp. " . number_format($value) . "";
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } elseif ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } elseif ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } elseif ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } elseif ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return ucwords($hasil);
}

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
