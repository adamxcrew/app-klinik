<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = "gaji";

    protected $fillable = ['pegawai_id', 'periode', 'status_bayar', 'approval'];

    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Pegawai::class);
    }
}
