<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    protected $table = "diagnosa";

    protected $fillable = [
        'kode',
        'nama',
        'aktif'
    ];
}
