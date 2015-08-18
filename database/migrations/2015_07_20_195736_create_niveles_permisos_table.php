<?php

use Illuminate\Database\Migrations\Migration;

class CreateNivelesPermisosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('niveles_permisos', function ($table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->integer('nivel')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('niveles_permisos');
    }
}
