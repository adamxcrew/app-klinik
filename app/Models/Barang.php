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
        'keterangan',
        'jenis_barang',
        'kategori_id',
        'satuan_terbesar_id',
        'satuan_terkecil_id',
        'margin',
        'pelayanan',
        'jumlah_satuan_terbesar',
        'jumlah_satuan_terkecil'
    ];

    public function satuanTerbesar()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'satuan_terbesar_id', 'id');
    }

    public function satuanTerkecil()
    {
        return $this->belongsTo(\App\Models\Satuan::class, 'satuan_terkecil_id', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(\App\Models\Kategori::class);
    }
}
