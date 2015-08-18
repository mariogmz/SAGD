<?php

use Illuminate\Database\Migrations\Migration;

class AddSucursalesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sucursales', function ($table) {
            // Foreign Key Fields
            $table->integer('proveedor_id')->unsigned();
            $table->integer('domicilio_id')->unsigned();
            // Constraints
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreign('domicilio_id')->references('id')->on('domicilios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sucursales', function ($table) {
            $table->dropForeign('sucursales_proveedor_id_foreign');
            $table->dropForeign('sucursales_domicilio_id_foreign');
            $table->dropColumn(['proveedor_id', 'domicilio_id']);
        });
    }
}
