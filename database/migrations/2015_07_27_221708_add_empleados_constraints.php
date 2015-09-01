<?php

use Illuminate\Database\Migrations\Migration;

class AddEmpleadosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('empleados', function ($table) {
            // Foreign Key Fields
            $table->integer('sucursal_id')->unsigned();
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('empleados', function ($table) {
            $table->dropForeign('empleados_sucursal_id_foreign');
            $table->dropColumn('sucursal_id');
        });
    }
}
