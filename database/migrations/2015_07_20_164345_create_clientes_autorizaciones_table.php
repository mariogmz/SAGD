<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientesAutorizacionesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('clientes_autorizaciones', function ($table) {
            $table->increments('id');
            $table->string('nombre_autorizado', 200)->nullable();
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
        Schema::drop('clientes_autorizaciones');
    }
}
