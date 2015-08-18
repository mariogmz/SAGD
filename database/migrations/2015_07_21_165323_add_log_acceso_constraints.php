<?php

use Illuminate\Database\Migrations\Migration;

class AddLogAccesoConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('log_acceso', function ($table) {
            $table->integer('empleado_id')->unsigned();
            $table->foreign('empleado_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('log_acceso', function ($table) {
            $table->dropForeign('log_acceso_empleado_id_foreign');
            $table->dropColumn('empleado_id');
        });
    }
}
