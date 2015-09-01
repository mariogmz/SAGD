<?php

use Illuminate\Database\Migrations\Migration;

class CreateCodigosPostalesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('codigos_postales', function ($table) {
            $table->increments('id');
            $table->string('estado', 45);
            $table->string('municipio', 50);
            $table->string('codigo_postal', 5);
            $table->unique('codigo_postal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('codigos_postales');
    }
}
