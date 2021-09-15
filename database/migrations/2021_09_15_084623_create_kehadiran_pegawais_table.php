<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKehadiranPegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kehadiran_pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jam_masuk');
            $table->string('jam_keluar');
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'tidak hadir', 'izin', 'sakit']);
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
        Schema::dropIfExists('kehadiran_pegawais');
    }
}
