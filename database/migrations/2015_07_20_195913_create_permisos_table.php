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
            $table->char('clave', 10);
            $table->string('nombre', 45);
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
        Schema::drop('permisos');
    }
}
