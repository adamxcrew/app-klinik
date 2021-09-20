<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPraktek extends Model
{
    protected $table = 'jadwal_praktek';
    protected $fillable = ['user_id', 'hari', 'jam'];
}
