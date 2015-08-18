<?php

use Illuminate\Database\Migrations\Migration;

class CreateTiposPartidasCortesConceptosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('tipos_partidas_cortes_conceptos', function ($table) {
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('tipos_partidas_cortes_conceptos');
    }
}
