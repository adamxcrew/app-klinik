<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('kewarganegaraan');
            $table->string('suku_bangsa');
            $table->string('golongan_darah', 5);
            $table->string('privilage_khusus', 20);
            $table->string('penanggung_jawab');
            $table->string('hubungan_pasien', 30);
            $table->text('alamat_penanggung_jawab');
            $table->string('no_telp_penanggung_jawab');
            $table->string('penjamin');
            $table->string('nomor_asuransi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasien', function (Blueprint $table) {
            //
        });
    }
}
