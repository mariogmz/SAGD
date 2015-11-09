<?php

use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('empleados_roles', function ($table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('empleados_roles');
    }
}
