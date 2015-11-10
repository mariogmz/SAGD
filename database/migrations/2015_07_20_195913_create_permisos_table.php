<?php

use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('permisos', function ($table) {
            $table->increments('id');
            $table->string('controlador', 45);
            $table->string('accion', 45);
            $table->string('descripcion', 140);
            $table->unique(['controlador', 'accion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('permisos');
    }
}
