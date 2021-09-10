<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
    protected $table="poliklinik";

    protected $fillable=['nomor_poli','nama','keterangan','aktif'];
}
