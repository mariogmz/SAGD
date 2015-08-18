<?php

use Illuminate\Database\Migrations\Migration;

class AddRolesPermisosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('roles_permisos', function ($table) {
            $table->integer('rol_id')->unsigned();
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
        Schema::table('roles_permisos', function ($table) {
            $table->dropForeign('roles_permisos_rol_id_foreign');
            $table->dropColumn('rol_id');
        });
    }
}
