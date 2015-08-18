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
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos');
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
            $table->dropForeign('productos_movimientos_producto_id_foreign');
            $table->dropColumn('producto_id');
        });
    }
}
