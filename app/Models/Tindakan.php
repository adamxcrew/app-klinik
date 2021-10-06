<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    protected $table = "tindakan";

    protected $fillable = ['kode','tindakan','tarif_umum','tarif_bpjs','tarif_perusahaan','pembagian_tarif'];

    public function getPembagianTarifAttribute($value)
    {
        return unserialize($value);
    }
}
