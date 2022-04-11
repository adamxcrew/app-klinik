<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranResep extends Model
{
    protected $table = "pendaftaran_resep";

    protected $fillable = ['tindakan_id', 'pendaftaran_id', 'barang_id', 'jumlah', 'satuan_terkecil_id', 'aturan_pakai', 'jenis', 'harga' ];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang');
    }


    public function satuanObat()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'satuan', 'id');
    }
}
