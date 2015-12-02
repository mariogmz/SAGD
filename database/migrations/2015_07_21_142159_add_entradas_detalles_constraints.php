<?php

use Illuminate\Database\Migrations\Migration;

class AddEntradasDetallesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('entradas_detalles', function ($table) {
            // Foreign Key fields
            $table->integer('entrada_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('producto_movimiento_id')->unsigned()->nullable();
            // Constraints
            $table->foreign('entrada_id')->references('id')->on('entradas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('entradas_detalles', function ($table) {
            $table->dropForeign('entradas_detalles_entrada_id_foreign');
            $table->dropForeign('entradas_detalles_producto_id_foreign');
            $table->dropColumn(['entrada_id', 'producto_id']);
        });
    }
}
