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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('id_kategori', 36);
            $table->foreign('id_kategori')->references('id')->on('kategori')->onUpdate('cascade')->onDelete('restrict');
            $table->string('id_satuan', 36);
            $table->foreign('id_satuan')->references('id')->on('satuan')->onUpdate('cascade')->onDelete('restrict');
            $table->string('nama_barang');
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
