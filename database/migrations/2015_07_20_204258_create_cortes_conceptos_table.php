<?php

use Illuminate\Database\Migrations\Migration;

class CreateCortesConceptosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('cortes_conceptos', function ($table) {
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
        Schema::drop('cortes_conceptos');
    }
}
