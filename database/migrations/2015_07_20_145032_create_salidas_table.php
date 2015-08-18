<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalidasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('salidas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_salida')->nullable();
            $table->string('motivo', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('salidas');
    }
}
