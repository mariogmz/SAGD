<?php

use Illuminate\Database\Migrations\Migration;

class AddProductosSucursalesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('productos_sucursales', function ($table) {
            $table->integer('producto_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();

            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('productos_sucursales', function ($table) {
            $table->dropForeign('productos_sucursales_producto_id_foreign');
            $table->dropForeign('productos_sucursales_sucursal_id_foreign');

            $table->dropColumn(['producto_id', 'sucursal_id']);
        });
    }
}
