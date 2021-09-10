<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table="obat";

    protected $fillable=[
        'nama_obat',
        'kode',
        'status',
        'harga',
        'stock',
        'satuan_id'
    ];

    public function satuan()
    {
        return $this->belongsTo(\App\Models\Satuan::class);
    }
}
