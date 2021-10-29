<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranResep extends Model
{
    protected $table = "pendaftaran_resep";

    protected $fillable = [ 'pendaftaran_id', 'barang_id', 'jumlah', 'satuan', 'aturan_pakai', 'jenis', 'harga' ];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }
}
