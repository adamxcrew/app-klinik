<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewPendaftaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("create view view_pendaftaran as select pa.nomor_rekam_medis,pa.nama,na.nomor_antrian,left(na.created_at,10)as tanggal,po.nomor_poli as nama_poliklinik,po.id as poliklinik_id,u.name as nama_dokter,pas.nama_perusahaan,na.status_pelayanan,na.sudah_dipanggil,na.status_pembayaran
        from nomor_antrian as na left join pendaftaran as p on na.pendaftaran_id=p.id
        left join pasien as pa on pa.id=p.pasien_id
        left join poliklinik as po on po.id=na.poliklinik_id
        left JOIN users as u on u.id=na.dokter_id
        left join perusahaan_asuransi as pas on pas.id=na.perusahaan_asuransi_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_pendaftarans');
    }
}