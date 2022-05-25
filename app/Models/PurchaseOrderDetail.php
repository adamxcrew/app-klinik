<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_detail';

    protected $fillable = ['barang_id', 'qty', 'harga', 'purchase_order_id', 'qty_diterima','approval','catatan','diskon'];

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'barang_id', 'id');
    }
}
