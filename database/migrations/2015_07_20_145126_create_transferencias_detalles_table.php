<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferenciasDetallesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias_detalles', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('cantidad')->default(0);
            $table->integer('existencia_origen_antes')->default(0)->unsigned();
            $table->integer('existencia_origen_despues')->default(0)->unsigned();
            $table->integer('existencia_destino_antes')->default(0)->unsigned();
            $table->integer('existencia_destino_despues')->default(0)->unsigned();
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
        Schema::drop('transferencias_detalles');
    }
}
