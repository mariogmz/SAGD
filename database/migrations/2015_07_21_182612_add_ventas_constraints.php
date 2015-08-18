<?php

use Illuminate\Database\Migrations\Migration;

class AddVentasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('ventas', function ($table) {
            $table->integer('sucursal_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('caja_id')->unsigned();
            $table->integer('corte_id')->unsigned()->nullable();
            $table->integer('estatus_venta_id')->unsigned();
            $table->integer('estado_venta_id')->unsigned();
            $table->integer('tipo_venta_id')->unsigned();
            $table->integer('sucursal_entrega_id')->unsigned();
            $table->integer('empleado_id')->unsigned()->nullable();

            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->foreign('corte_id')->references('id')->on('cortes');
            $table->foreign('estatus_venta_id')->references('id')->on('estatus_ventas');
            $table->foreign('estado_venta_id')->references('id')->on('estados_ventas');
            $table->foreign('tipo_venta_id')->references('id')->on('tipos_ventas');
            $table->foreign('sucursal_entrega_id')->references('id')->on('sucursales');
            $table->foreign('empleado_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('ventas', function ($table) {
            $table->dropForeign('ventas_sucursal_id_foreign');
            $table->dropForeign('ventas_cliente_id_foreign');
            $table->dropForeign('ventas_caja_id_foreign');
            $table->dropForeign('ventas_corte_id_foreign');
            $table->dropForeign('ventas_estatus_venta_id_foreign');
            $table->dropForeign('ventas_estado_venta_id_foreign');
            $table->dropForeign('ventas_tipo_venta_id_foreign');
            $table->dropForeign('ventas_sucursal_entrega_id_foreign');
            $table->dropForeign('ventas_empleado_id_foreign');

            $table->dropColumn(['sucursal_entrega_id', 'tipo_venta_id', 'estado_venta_id', 'estatus_venta_id', 'corte_id', 'caja_id', 'cliente_id', 'sucursal_id', 'empleado_id']);
        });
    }
}
