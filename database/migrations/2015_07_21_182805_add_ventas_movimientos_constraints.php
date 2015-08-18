<?php

use Illuminate\Database\Migrations\Migration;

class AddVentasMovimientosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('ventas_movimientos', function ($table) {
            $table->integer('venta_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            $table->integer('estatus_venta_id')->unsigned();
            $table->integer('estado_venta_id')->unsigned();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('estatus_venta_id')->references('id')->on('estatus_ventas');
            $table->foreign('estado_venta_id')->references('id')->on('estados_ventas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('ventas_movimientos', function ($table) {
            $table->dropForeign('ventas_movimientos_venta_id_foreign');
            $table->dropForeign('ventas_movimientos_empleado_id_foreign');
            $table->dropForeign('ventas_movimientos_estatus_venta_id_foreign');
            $table->dropForeign('ventas_movimientos_estado_venta_id_foreign');

            $table->dropColumn(['estado_venta_id', 'estatus_venta_id', 'empleado_id', 'venta_id']);
        });
    }
}
