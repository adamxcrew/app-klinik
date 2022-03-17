<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranObatRacikDetail extends Model
{
    protected $table = 'pendaftaran_obat_racik_detail';

    protected $fillable = ['pendaftaran_obat_racik_id','barang_id','jumlah'];
}
