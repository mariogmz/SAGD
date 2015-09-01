<?php

use Illuminate\Database\Migrations\Migration;

class AddCortesDetallesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cortes_detalles', function ($table) {
            $table->integer('corte_id')->unsigned();
            $table->integer('corte_concepto_id')->unsigned();
            $table->foreign('corte_id')->references('id')->on('cortes');
            $table->foreign('corte_concepto_id')->references('id')->on('cortes_conceptos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cortes_detalles', function ($table) {
            $table->dropForeign('cortes_detalles_corte_id_foreign');
            $table->dropForeign('cortes_detalles_corte_concepto_id_foreign');
            $table->dropColumn(['corte_id', 'corte_concepto_id']);
        });
    }
}
