<?php

use Illuminate\Database\Migrations\Migration;

class CreateTiposCortesConceptosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('tipos_cortes_conceptos', function ($table) {
            $table->increments('id');
            $table->string('nombre', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('tipos_cortes_conceptos');
    }
}
