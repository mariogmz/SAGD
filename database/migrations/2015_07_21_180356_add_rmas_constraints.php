<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRmasConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('rmas', function($table){
            $table->integer('estado_rma_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->integer('rma_tiempo_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('nota_credito_id')->unsigned()->nullable();

            $table->foreign('estado_rma_id')->references('id')->on('estados_rmas');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('rma_tiempo_id')->references('id')->on('rmas_tiempos');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
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
        Schema::table('rmas', function($table){
            $table->dropForeign('rmas_nota_credito_id_foreign');
            $table->dropForeign('rmas_sucursal_id_foreign');
            $table->dropForeign('rmas_rma_tiempo_id_foreign');
            $table->dropForeign('rmas_empleado_id_foreign');
            $table->dropForeign('rmas_cliente_id_foreign');
            $table->dropForeign('rmas_estado_rma_id_foreign');

            $table->dropColumn(['nota_credito_id', 'sucursal_id', 'rma_tiempo_id', 'empleado_id', 'cliente_id', 'estado_rma_id']);
        });
    }
}
