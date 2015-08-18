<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientesEstatusTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('clientes_estatus', function ($table) {
            $table->increments('id');
            $table->string('nombre', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('clientes_estatus');
    }
}
