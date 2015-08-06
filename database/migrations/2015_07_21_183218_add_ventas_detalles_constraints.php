<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVentasDetallesConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ventas_detalles', function($table){
            $table->integer('venta_id')->unsigned();
            $table->integer('tipo_partida_id')->unsigned();
            $table->integer('producto_id')->unsigned()->nullable();
            $table->integer('metodo_pago_id')->unsigned()->nullable();
            $table->integer('factura_id')->unsigned()->nullable();
            $table->integer('nota_credito_id')->unsigned()->nullable();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('tipo_partida_id')->references('id')->on('tipos_partidas');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('metodo_pago_id')->references('id')->on('metodos_pagos');
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->foreign('nota_credito_id')->references('id')->on('notas_creditos');
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
        Schema::table('ventas_detalles', function($table){
            $table->dropForeign('ventas_detalles_venta_id_foreign');
            $table->dropForeign('ventas_detalles_tipo_partida_id_foreign');
            $table->dropForeign('ventas_detalles_producto_id_foreign');
            $table->dropForeign('ventas_detalles_metodo_pago_id_foreign');
            $table->dropForeign('ventas_detalles_factura_id_foreign');
            $table->dropForeign('ventas_detalles_nota_credito_id_foreign');

            $table->dropColumn(['nota_credito_id', 'factura_id', 'metodo_pago_id', 'producto_id', 'tipo_partida_id', 'venta_id']);
        });
    }
}
