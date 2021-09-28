<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'kode',
        'jenis',
        'aktif',
        'harga',
        'stock',
        'keterangan',
        'jenis_barang',
        'kategori_id',
        'satuan_id'
    ];

    public function satuan()
    {
        return $this->belongsTo(\App\Models\Satuan::class);
    }

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Kategori::class);
    }
}
