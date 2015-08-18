<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmpleadosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->string('usuario', 20);
            $table->string('password', 64);
            $table->boolean('activo')->default(false);
            $table->string('puesto', 45)->nullable();
            $table->timestamp('fecha_cambio_password')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fecha_ultimo_ingreso')->nullable();
            $table->string('access_token', 20);

            $table->unique('usuario');
            $table->unique('access_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('empleados');
    }
}
