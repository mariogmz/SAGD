<?php

use Illuminate\Database\Migrations\Migration;

class AddCortesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('cortes', function ($table) {
            // Foreign Key Fields
            $table->integer('empleado_id')->unsigned();
            $table->integer('caja_id')->unsigned()->nullable();
            $table->integer('corte_global_id')->unsigned()->nullable();
            // Constraints
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->foreign('corte_global_id')->references('id')->on('cortes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('cortes', function ($table) {
            $table->dropForeign('cortes_corte_global_id_foreign');
            $table->dropForeign('cortes_caja_id_foreign');
            $table->dropForeign('cortes_empleado_id_foreign');
            $table->dropColumn('empleado_id');
            $table->dropColumn('caja_id');
            $table->dropColumn('corte_global_id');
        });
    }
}
