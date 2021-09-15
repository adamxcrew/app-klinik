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
        'kewarganegaraan',
        'golongan_darah',
        'privilage_khusus',
        'penanggung_jawab',
        'suku_bangsa',
        'hubungan_pasien',
        'alamat_penanggung_jawab',
        'no_telp_penanggung_jawab',
        'nomor_rekam_medis',
        'penjamin'
    ];
}
