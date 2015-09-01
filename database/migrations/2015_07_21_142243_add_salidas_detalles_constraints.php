<?php

use Illuminate\Database\Migrations\Migration;

class AddSalidasDetallesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('salidas_detalles', function ($table) {
            // Foreign Key Fields
            $table->integer('salida_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('producto_movimiento_id')->unsigned();
            // Constraints
            $table->foreign('salida_id')->references('id')->on('salidas')->onDelete('cascade');
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
        Schema::table('salidas_detalles', function ($table) {
            $table->dropForeign('salidas_detalles_salida_id_foreign');
            $table->dropForeign('salidas_detalles_producto_id_foreign');
            $table->dropForeign('salidas_detalles_producto_movimiento_id_foreign');
            $table->dropColumn(['salida_id', 'producto_id', 'producto_movimiento_id']);
        });
    }
}
