<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPretransferenciasConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pretransferencias', function($table){
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->integer('sucursal_origen_id')->unsigned();
            $table->foreign('sucursal_origen_id')->references('id')->on('sucursales');

            $table->integer('sucursal_destino_id')->unsigned();
            $table->foreign('sucursal_destino_id')->references('id')->on('sucursales');

            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pretransferencias', function($table){
            $table->dropForeign('pretransferencias_producto_id_foreign');
            $table->dropForeign('pretransferencias_sucursal_origen_id_foreign');
            $table->dropForeign('pretransferencias_sucursal_destino_id_foreign');
            $table->dropForeign('pretransferencias_empleado_id_foreign');
            $table->dropColumn(['producto_id', 'sucursal_origen_id', 'sucursal_destino_id', 'empleado_id']);
        });
    }
}
