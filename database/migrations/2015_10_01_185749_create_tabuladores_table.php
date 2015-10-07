<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabuladoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tabuladores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tabulador')->default(1)->unsigned();
            $table->integer('tabulador_original')->default(1)->unsigned();
            $table->boolean('habilitada')->default(false)->unsigned();
            $table->boolean('venta_especial')->default(false)->unsigned();
            $table->softDeletes();
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
        Schema::drop('tabuladores');
    }
}
