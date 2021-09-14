<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = "pegawai";

    protected $fillable = ['nama', 'nip', 'tempat_lahir', 'tanggal_lahir', 'kelompok_pegawai', 'agama', 'jenis_kelamin', 'alamat'];
}
