<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = "pendaftaran";

    protected $fillable = ['kode','pasien_id','dokter_id','jenis_layanan','status_pembayaran','poliklinik_id'];
}
