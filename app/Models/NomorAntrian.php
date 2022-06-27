<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class NomorAntrian extends Model
{
    protected $table = "nomor_antrian";

    protected $fillable = ['pendaftaran_id','poliklinik_id','nomor_antrian','dokter_id','tindakan_id','status_pemeriksaan','sudah_dipanggil'];


    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id', 'id');
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id', 'id');
    }
    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan', 'tindakan_id', 'id');
    }
}
