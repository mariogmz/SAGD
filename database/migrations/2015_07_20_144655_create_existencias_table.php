<?php

use Illuminate\Database\Migrations\Migration;

class CreateExistenciasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('existencias', function ($table) {
            $table->increments('id');
            $table->integer('cantidad')->default(0)->unsigned();
            $table->integer('cantidad_apartado')->default(0)->unsigned();
            $table->integer('cantidad_pretransferencia')->default(0)->unsigned();
            $table->integer('cantidad_transferencia')->default(0)->unsigned();
            $table->integer('cantidad_garantia_cliente')->default(0)->unsigned();
            $table->integer('cantidad_garantia_zegucom')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('existencias');
    }
}
