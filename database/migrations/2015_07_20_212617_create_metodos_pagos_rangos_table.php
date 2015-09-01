<?php

use Illuminate\Database\Migrations\Migration;

class CreateMetodosPagosRangosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('metodos_pagos_rangos', function ($table) {
            $table->increments('id');
            $table->decimal('desde', 3, 2)->default(0.0);
            $table->decimal('hasta', 3, 2)->default(0.0);
            $table->decimal('valor', 3, 2)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('metodos_pagos_rangos');
    }
}
