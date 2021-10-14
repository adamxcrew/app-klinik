<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranTindakan extends Model
{
    protected $table = "pendaftaran_tindakan";

    protected $fillable = ['tindakan_id','pendaftaran_id'];

    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan');
    }
}
