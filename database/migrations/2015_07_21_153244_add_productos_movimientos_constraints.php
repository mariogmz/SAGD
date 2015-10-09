<?php

use Illuminate\Database\Migrations\Migration;

class AddProductosMovimientosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('productos_movimientos', function ($table) {
            $table->integer('producto_sucursal_id')->unsigned();
            $table->foreign('producto_sucursal_id')->references('id')->on('productos_sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('productos_movimientos', function ($table) {
            $table->dropForeign('productos_movimientos_producto_sucursal_id_foreign');
            $table->dropColumn('producto_sucursal_id');
        });
    }
}
