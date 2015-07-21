<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExistenciasConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('existencias', function($table){
            $table->integer('productos_sucursales_producto_id')->unsigned();
            $table->integer('productos_sucursales_sucursal_id')->unsigned();

            $table->foreign('productos_sucursales_producto_id')->references('producto_id')->on('productos_sucursales');
            $table->foreign('productos_sucursales_sucursal_id')->references('sucursal_id')->on('productos_sucursales');
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
        Schema::table('existencias', function($table){
            $table->dropForeign('existencias_productos_sucursales_producto_id_foreign');
            $table->dropForeign('existencias_productos_sucursales_sucursal_id_foreign');

            $table->dropColumn(['productos_sucursales_sucursal_id', 'productos_sucursales_producto_id']);
        });
    }
}
