<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = "pasien";

    protected $fillable = [
        'nomor_ktp',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor_hp',
        'pekerjaan',
        'alamat',
        'rt_rw',
        'jenis_kelamin',
        'pendidikan',
        'agama',
        'status_pernikahan',
        'nama_ibu',
        'nomor_rekam_medis'
    ];
}
