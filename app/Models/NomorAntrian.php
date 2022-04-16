<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class NomorAntrian extends Model
{
    protected $table = "nomor_antrian";

    protected $fillable = ['pendaftaran_id','poliklinik_id','nomor_antrian','dokter_id'];


    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id', 'id');
    }
}
