<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranFeeTindakan extends Model
{
    protected $table = "pendaftaran_fee_tindakan";

    protected $fillable = ['tindakan_id','pendaftaran_id','jumlah_fee','user_id','pelaksana'];

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan');
    }

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Pegawai', 'user_id', 'id');
    }
}
