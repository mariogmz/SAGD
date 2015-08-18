<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApartadosDetallesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('apartados_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad')->unsigned()->default(0);
            $table->integer('existencia_antes')->unsigned()->default(0);
            $table->integer('existencia_despues')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('apartados_detalles');
    }
}
