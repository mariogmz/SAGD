<?php

use Illuminate\Database\Migrations\Migration;

class AddGarantiasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('garantias', function ($table) {
            $table->integer('venta_detalle_id')->unsigned()->nullable();
            $table->foreign('venta_detalle_id')->references('id')->on('ventas_detalles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('garantias', function ($table) {
            $table->dropForeign('garantias_venta_detalle_id_foreign');
            $table->dropColumn('venta_detalle_id');
        });
    }
}
