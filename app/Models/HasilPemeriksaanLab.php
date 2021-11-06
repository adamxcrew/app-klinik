<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPemeriksaanLab extends Model
{
    protected $table = "pendaftaran_hasil_pemeriksaan_lab";

    protected $fillable = [ 'pendaftaran_id', 'indikator_pemeriksaan_lab_id', 'hasil', 'catatan', 'analisis_laboratorium'];

    public function indikator()
    {
        return $this->belongsTo('App\Models\IndikatorPemeriksaanLab', 'indikator_pemeriksaan_lab_id');
    }
}
