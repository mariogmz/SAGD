<?php

use Illuminate\Database\Migrations\Migration;

class AddSucursalesEnviosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sucursales_envios', function ($table) {
            // Foreign Key Field
            $table->integer('sucursal_origen_id')->unsigned();
            $table->integer('sucursal_destino_id')->unsigned();
            // Constraints
            $table->foreign('sucursal_origen_id')->references('id')->on('sucursales');
            $table->foreign('sucursal_destino_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sucursales_envios', function ($table) {
            $table->dropForeign('sucursales_envios_sucursal_origen_id_foreign');
            $table->dropForeign('sucursales_envios_sucursal_destino_id_foreign');
            $table->dropColumn(['sucursal_origen_id', 'sucursal_destino_id']);
        });
    }
}
