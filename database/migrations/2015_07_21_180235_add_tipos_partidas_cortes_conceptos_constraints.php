<?php

use Illuminate\Database\Migrations\Migration;

class AddTiposPartidasCortesConceptosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('tipos_partidas_cortes_conceptos', function ($table) {
            // Foreign Key Fields
            $table->integer('tipo_partida_id')->unsigned();
            $table->integer('corte_concepto_id')->unsigned();
            // Constraints
            $table->foreign('tipo_partida_id')->references('id')->on('tipos_partidas');
            $table->foreign('corte_concepto_id')->references('id')->on('cortes_conceptos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('tipos_partidas_cortes_conceptos', function ($table) {
            $table->dropForeign('tipos_partidas_cortes_conceptos_tipo_partida_id_foreign');
            $table->dropForeign('tipos_partidas_cortes_conceptos_corte_concepto_id_foreign');
            $table->dropColumn(['tipo_partida_id', 'corte_concepto_id']);
        });
    }
}
