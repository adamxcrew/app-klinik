<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = "pendaftaran";

    protected $fillable = ['kode','pasien_id','dokter_id','jenis_layanan','status_pembayaran','poliklinik_id'];

    public function pasien()
    {
        return $this->belongsTo('App\Models\Pasien', 'pasien_id', 'id');
    }

    public function poliklinik()
    {
        return $this->belongsTo('App\Models\Poliklinik', 'poliklinik_id', 'id');
    }
}
