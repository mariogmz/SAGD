<?php

use Illuminate\Database\Migrations\Migration;

class CreateTiposPartidasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('tipos_partidas', function ($table) {
            $table->increments('id');
            $table->string('clave', 25);
            $table->string('nombre', 50);
            $table->boolean('ticket')->default(false);
            $table->boolean('ticket_suma')->default(false);
            $table->boolean('pago')->default(false);
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
        Schema::drop('tipos_partidas');
    }
}
