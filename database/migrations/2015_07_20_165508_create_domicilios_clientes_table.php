<?php

use Illuminate\Database\Migrations\Migration;

class CreateDomiciliosClientesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('domicilios_clientes', function ($table) {
            $table->increments('id');
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
        Schema::drop('domicilios_clientes');
    }
}
