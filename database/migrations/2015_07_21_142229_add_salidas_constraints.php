<?php

use Illuminate\Database\Migrations\Migration;

class AddSalidasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('salidas', function ($table) {
            // Foreign Key Fields
            $table->integer('empleado_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('estado_salida_id')->unsigned();
            // Constraints
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('estado_salida_id')->references('id')->on('estados_salidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('salidas', function ($table) {
            $table->dropForeign('salidas_empleado_id_foreign');
            $table->dropForeign('salidas_sucursal_id_foreign');
            $table->dropForeign('salidas_estado_salida_id_foreign');
            $table->dropColumn(['empleado_id', 'sucursal_id', 'estado_salida_id']);
        });
    }
}
