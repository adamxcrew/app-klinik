<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table    = "surat";
    protected $fillable = [
        'pendaftaran_id',
        'dokter_id',
        'jenis_surat',
        'keperluan',
        'kesan',
        'terapi_yang_telah_diberikan',
        'lain_lain',
        'diagnosa_sementara',
        'hasil_pemeriksaan_mata',
        'saran',
        'tindakan_yang_telah_dilakukan'
    ];



    public function pendaftaran()
    {
        return $this->belongsTo('App\Models\Pendaftaran');
    }
}
