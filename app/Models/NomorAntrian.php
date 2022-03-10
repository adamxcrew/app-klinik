<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorAntrian extends Model
{
    protected $table = "nomor_antrian";

    protected $fillable = ['pendaftaran_id','poliklinik_id','nomor_antrian','dokter_id'];
}
