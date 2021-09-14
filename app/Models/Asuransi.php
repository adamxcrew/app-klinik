<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    protected $table = "asuransi";

    protected $fillable = ['nama', 'alamat', 'no_telp', 'contact_person', 'no_telp_cp', 'mulai_kontrak', 'akhir_kontrak', 'kelompok_perusahaan', 'kelompok'];
}
