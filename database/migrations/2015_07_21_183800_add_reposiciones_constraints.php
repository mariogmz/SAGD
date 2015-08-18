<?php

use Illuminate\Database\Migrations\Migration;

class AddReposicionesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('reposiciones', function ($table) {
            $table->integer('producto_id')->unsigned();
            $table->integer('garantia_id')->unsigned();
            $table->integer('proveedor_id')->unsigned();

            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('garantia_id')->references('id')->on('garantias');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('reposiciones', function ($table) {
            $table->dropForeign('reposiciones_producto_id_foreign');
            $table->dropForeign('reposiciones_garantia_id_foreign');
            $table->dropForeign('reposiciones_proveedor_id_foreign');

            $table->dropColumn(['proveedor_id', 'garantia_id', 'producto_id']);
        });
    }
}
