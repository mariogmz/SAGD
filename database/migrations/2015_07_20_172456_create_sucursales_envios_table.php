<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesEnviosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales_envios', function (Blueprint $table)
        {
            $table->integer('sucursal_origen_id');
            $table->integer('sucursal_destino_id');
            $table->boolean('genera_costo')->default(false);
            $table->integer('dias_max_envio')->unsigned()->default(0);
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
}
