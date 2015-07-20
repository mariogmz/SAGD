<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodosPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('metodos_pagos', function($table){
            $table->increments('id');
            $table->string('clave', 10);
            $table->string('nombre', 45)->nullable();
            $table->decimal('comision', 4, 3)->default(0.0)->unsigned();
            $table->decimal('monto_minimo', 10, 2)->default(0.0)->unsigned();
            $table->string('informacion_adicional', 100)->nullable();
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
        Schema::drop('metodos_pagos');
    }
}
