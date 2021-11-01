<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPemeriksaanLab extends Model
{
    protected $table = "jenis_pemeriksaan_laboratorium";

    protected $fillable = ['nama_jenis'];
}
