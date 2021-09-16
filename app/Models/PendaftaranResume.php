<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranResume extends Model
{
    protected $table = 'pendaftaran_resume';

    protected $fillable = ['pendaftaran_id', 'jenis', 'jenis_resume_id', 'jumlah', 'keterangan'];

    public function diagnosa()
    {
        return $this->belongsTo('App\Models\Diagnosa', 'jenis_resume_id', 'id');
    }

    public function obat()
    {
        return $this->belongsTo('App\Models\Obat', 'jenis_resume_id', 'id');
    }

    public function tindakan()
    {
        return $this->belongsTo('App\Models\Tindakan', 'jenis_resume_id', 'id');
    }
}
