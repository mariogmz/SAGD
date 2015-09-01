<?php

use Illuminate\Database\Migrations\Migration;

class CreateEstadosVentasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('estados_ventas', function ($table) {
            $table->increments('id');
            $table->char('clave', 1);
            $table->string('nombre', 90);
            $table->unique('clave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('estados_ventas');
    }
}
