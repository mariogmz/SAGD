<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApartadosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('apartados', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_apartado')->nullable();
            $table->timestamp('fecha_desapartado')->nullable();
            $table->string('concepto', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('apartados');
    }
}
