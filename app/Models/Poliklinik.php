<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    protected $table = "poliklinik";

    protected $fillable = ['nomor_poli','nama','keterangan','aktif'];



    public function scopeKunjunganPasienPerPoli($query, $tanggal_awal, $tanggal_akhir)
    {
        return $query->leftJoin('pendaftaran', function ($join) use ($tanggal_awal, $tanggal_akhir) {
            $join->on('pendaftaran.poliklinik_id', '=', 'poliklinik.id');
            $join->whereBetween('pendaftaran.created_at', [$tanggal_awal,$tanggal_akhir]);
        })
        ->selectRaw('poliklinik.nama,poliklinik.nomor_poli, count(pendaftaran.id) as jumlah_kunjungan')
        ->groupBy('poliklinik.id');
    }
}
