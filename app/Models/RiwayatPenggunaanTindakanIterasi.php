<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPenggunaanTindakanIterasi extends Model
{
    protected $table = 'riwayat_penggunaan_tindakan_iterasi';

    protected $fillable = ['pendaftaran_id','paket_iterasi_id'];
}
