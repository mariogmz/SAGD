<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clientes_sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tabulador')->default(1)->unsigned();
            $table->integer('tabulador_original')->default(1)->unsigned();
            $table->boolean('habilitada')->default(false)->unsigned();
            $table->boolean('venta_especial')->default(false)->unsigned();
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
        Schema::drop('clientes_sucursales');
    }
}
