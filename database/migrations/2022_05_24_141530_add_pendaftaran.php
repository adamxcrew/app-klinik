<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order', function (Blueprint $table) {
            $table->integer('diskon');
        });
        Schema::table('purchase_order_detail', function (Blueprint $table) {
            $table->integer('diskon')->after('harga');
        });
        Schema::table('pendaftaran', function (Blueprint $table) {
            $table->integer('biaya_tambahan')->after('jumlah_bayar')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftaran', function (Blueprint $table) {
            //
        });
    }
}
