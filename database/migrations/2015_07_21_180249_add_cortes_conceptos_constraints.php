<?php

use Illuminate\Database\Migrations\Migration;

class AddCortesConceptosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cortes_conceptos', function ($table) {
            $table->integer('tipo_corte_concepto_id')->unsigned();
            $table->foreign('tipo_corte_concepto_id')->references('id')->on('tipos_cortes_conceptos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cortes_conceptos', function ($table) {
            $table->dropForeign('cortes_conceptos_tipo_corte_concepto_id_foreign');
        });
    }
}
