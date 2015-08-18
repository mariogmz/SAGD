<?php

use Illuminate\Database\Migrations\Migration;

class AddEmpleadosRolesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('empleados_roles', function ($table) {
            $table->integer('empleado_id')->unsigned();
            $table->integer('rol_id')->unsigned();

            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('rol_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('empleados_roles', function ($table) {
            $table->dropForeign('empleados_roles_empleado_id_foreign');
            $table->dropForeign('empleados_roles_rol_id_foreign');

            $table->dropColumn(['empleado_id', 'rol_id']);
        });
    }
}
