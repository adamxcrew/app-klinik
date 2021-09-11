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
