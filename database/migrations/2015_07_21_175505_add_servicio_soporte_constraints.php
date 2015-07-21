<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServicioSoporteConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('servicio_soporte', function($table){
            $table->integer('soporte_estatus_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->integer('cliente_id')->unsigned();

            $table->foreign('soporte_estatus_id')->references('id')->on('estados_soporte');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('cliente_id')->references('id')->on('clientes');
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
        Schema::table('servicio_soporte', function($table){
            $table->dropForeign('servicio_soporte_soporte_estatus_id_foreign');
            $table->dropForeign('servicio_soporte_empleado_id_foreign');
            $table->dropForeign('servicio_soporte_cliente_id_foreign');
            
            $table->dropColumn(['cliente_id', 'empleado_id', 'soporte_estatus_id']);
        });
    }
}
