<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiDetail extends Model
{
    protected $table = "gaji_detail";

    protected $fillable = ['gaji_id','komponen_gaji_id','jumlah','pegawai_id'];
}
