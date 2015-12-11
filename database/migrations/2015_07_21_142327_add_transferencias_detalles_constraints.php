<?php

use Illuminate\Database\Migrations\Migration;

class AddTransferenciasDetallesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('transferencias_detalles', function ($table) {
            // Foreign Key Fields
            $table->integer('transferencia_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('producto_movimiento_id')->unsigned()->nullable();

            // Constraints
            $table->foreign('transferencia_id')->references('id')->on('transferencias')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('producto_movimiento_id')->references('id')->on('productos_movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('transferencias_detalles', function ($table) {
            $table->dropForeign('transferencias_detalles_transferencia_id_foreign');
            $table->dropForeign('transferencias_detalles_producto_id_foreign');
            $table->dropForeign('transferencias_detalles_producto_movimiento_id_foreign');
            $table->dropColumn(['transferencia_id', 'producto_id', 'producto_movimiento_id']);
        });
    }
}
