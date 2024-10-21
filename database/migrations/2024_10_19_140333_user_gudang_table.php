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
        Schema::create('user_gudang', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('id_user', 36);
            $table->foreign('id_user')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->string('id_gudang', 36);
            $table->foreign('id_gudang')->references('id')->on('gudang')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();
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
