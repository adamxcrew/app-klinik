<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = "gaji";

    protected $fillable = ['kode', 'nama'];
}
