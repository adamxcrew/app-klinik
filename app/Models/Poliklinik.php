<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Poliklinik extends Model
{
    protected $table = "poliklinik";

    protected $fillable = ['nomor_poli','nama','keterangan','aktif','jenis_unit'];



    public function scopeKunjunganPasienPerPoli($query, $tanggal_awal, $tanggal_akhir)
    {
        return $query->leftJoin('nomor_antrian', function ($join) use ($tanggal_awal, $tanggal_akhir) {
            $join->on('nomor_antrian.poliklinik_id', '=', 'poliklinik.id');
            $join->whereBetween(DB::raw('DATE(nomor_antrian.created_at)'), [$tanggal_awal,$tanggal_akhir]);
        })
        ->selectRaw('poliklinik.nama,poliklinik.nomor_poli, count(nomor_antrian.id) as jumlah_kunjungan')
        ->groupBy('poliklinik.id');
    }
}
