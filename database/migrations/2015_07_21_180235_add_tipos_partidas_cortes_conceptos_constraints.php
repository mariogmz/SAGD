<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTiposPartidasCortesConceptosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipos_partidas_cortes_conceptos', function ($table)
        {
            // Foreign Key Fields
            $table->integer('caja_id')->unsigned();
            $table->integer('corte_id')->unsigned();
            // Constraints
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->foreign('corte_id')->references('id')->on('cortes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipos_partidas_cortes_conceptos', function ($table)
        {
            $table->dropForeign('tipos_partidas_cortes_conceptos_caja_id_foreign');
            $table->dropForeign('tipos_partidas_cortes_conceptos_corte_id_foreign');
            $table->dropColumn(['caja_id', 'corte_id']);
        });
    }
}
