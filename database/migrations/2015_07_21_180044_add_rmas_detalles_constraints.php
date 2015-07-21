<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRmasDetallesConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('rmas_detalles', function($table){
            $table->integer('rma_id')->unsigned();
            $table->integer('garantia_id')->unsigned();
            $table->integer('producto_movimiento_id')->unsigned();

            $table->foreign('rma_id')->references('id')->on('rmas')->onDelete('cascade');
            $table->foreign('garantia_id')->references('id')->on('garantias');
            $table->foreign('producto_movimiento_id')->references('id')->on('productos_movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('rmas_detalles', function($table){
            $table->dropForeign('rmas_detalles_rma_id_foreign');
            $table->dropForeign('rmas_detalles_garantia_id_foreign');
            $table->dropForeign('rmas_detalles_producto_movimiento_id_foreign');

            $table->dropColumn(['producto_movimiento_id', 'garantia_id', 'rma_id']);
        });
    }
}
