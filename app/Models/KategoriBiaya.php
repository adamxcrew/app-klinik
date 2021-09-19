<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBiaya extends Model
{
    protected $table = "kategori_biaya";

    protected $fillable = ['nama_kategori','keterangan'];
}
