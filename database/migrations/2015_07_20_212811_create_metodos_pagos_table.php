<?php

use Illuminate\Database\Migrations\Migration;

class CreateMetodosPagosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('metodos_pagos', function ($table) {
            $table->increments('id');
            $table->string('clave', 10);
            $table->string('nombre', 90)->nullable();
            $table->decimal('comision', 6, 5)->default(0.00000)->unsigned();
            $table->decimal('monto_minimo', 10, 2)->default(0.0)->unsigned();
            $table->string('informacion_adicional', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('metodos_pagos');
    }
}
