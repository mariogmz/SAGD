<?php

use Illuminate\Database\Migrations\Migration;

class CreateRolesPermisosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('roles_permisos', function ($table) {
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('roles_permisos');
    }
}
