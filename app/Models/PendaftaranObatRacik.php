<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranObatRacik extends Model
{
    protected $table = 'pendaftaran_obat_racik';

    protected $fillable = ['pendaftaran_id','aturan_pakai','kemasan','jumlah_kemasan'];
}
