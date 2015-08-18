<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSucursalesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave', 8);
            $table->string('nombre', 45);
            $table->string('horarios', 100);
            $table->string('ubicacion', 45)->nullable();
            $table->unique('clave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sucursales');
    }
}
