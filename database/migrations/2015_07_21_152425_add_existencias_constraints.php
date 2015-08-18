<?php

use Illuminate\Database\Migrations\Migration;

class AddExistenciasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('existencias', function ($table) {
            $table->integer('productos_sucursales_id')->unsigned();

            $table->foreign('productos_sucursales_id')->references('id')->on('productos_sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('existencias', function ($table) {
            $table->dropForeign('existencias_productos_sucursales_id_foreign');

            $table->dropColumn(['productos_sucursales_id']);
        });
    }
}
