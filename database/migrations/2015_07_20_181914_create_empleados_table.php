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
            $table->boolean('activo')->default(false);
            $table->string('puesto', 45)->nullable();
            $table->timestamp('fecha_cambio_password')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fecha_ultimo_ingreso')->nullable();

            $table->unique('usuario');
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
