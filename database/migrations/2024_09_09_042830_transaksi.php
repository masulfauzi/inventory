<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('id_barang_gudang', 36);
            $table->foreign('id_barang_gudang')->references('id')->on('barang_gudang')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('masuk');
            $table->integer('keluar');
            $table->date('tgl_transaksi');
            $table->string('bukti_transaksi');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by', 36)->nullable();
            $table->string('edited_by', 36)->nullable();
            $table->string('deleted_by', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
