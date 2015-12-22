<?php

use Illuminate\Database\Migrations\Migration;

class AddClientesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('clientes', function ($table) {
            $table->integer('cliente_estatus_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('cliente_referencia_id')->unsigned()->nullable();
            $table->integer('empleado_id')->unsigned()->nullable();
            $table->integer('vendedor_id')->unsigned()->nullable();
            $table->integer('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('roles');
            $table->foreign('cliente_estatus_id')->references('id')->on('clientes_estatus');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('cliente_referencia_id')->references('id')->on('clientes_referencias');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('vendedor_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('clientes', function ($table) {
            $table->dropForeign('clientes_cliente_estatus_id_foreign');
            $table->dropForeign('clientes_sucursal_id_foreign');
            $table->dropForeign('clientes_cliente_referencia_id_foreign');
            $table->dropForeign('clientes_empleado_id_foreign');
            $table->dropForeign('clientes_vendedor_id_foreign');
            $table->dropForeign('clientes_rol_id_foreign');

            $table->dropColumn(['vendedor_id', 'empleado_id', 'cliente_referencia_id', 'sucursal_id', 'cliente_estatus_id', 'rol_id']);
        });
    }
}
