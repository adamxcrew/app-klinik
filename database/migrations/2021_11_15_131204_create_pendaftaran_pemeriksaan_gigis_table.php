<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendaftaranPemeriksaanGigisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran_pemeriksaan_gigi', function (Blueprint $table) {
            $table->id();
            $table->integer('tbm_icd_id');
            $table->text('anamnesa', 255);
            $table->text('tindakan');
            $table->integer('pendaftaran_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran_pemeriksaan_gigi');
    }
}
