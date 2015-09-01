<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientesReferenciasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('clientes_referencias', function ($table) {
            $table->increments('id');
            $table->string('nombre', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('clientes_referencias');
    }
}
