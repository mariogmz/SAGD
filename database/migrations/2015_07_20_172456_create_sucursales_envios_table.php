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
            $table->increments('id');
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
        Schema::drop('sucursales_envios');
    }
}
