<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApartadosDetallesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartados_detalles', function ($table)
        {
            // Foreign Key Fields
            $table->integer('apartado_id')->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('producto_movimiento_id')->unsigned();
            // Constraints
            $table->foreign('apartado_id')->references('id')->on('apartados')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('producto_movimiento_id')->references('id')->on('productos_movimientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartados_detalles', function ($table)
        {
            $table->dropForeign('apartados_detalles_apartado_id_foreign');
            $table->dropForeign('apartados_detalles_producto_id_foreign');
            $table->dropForeign('apartados_detalles_producto_movimiento_id_foreign');
            $table->dropColumn(['apartado_id', 'producto_id', 'producto_movimiento_id']);
        });
    }
}
