<?php

use Illuminate\Database\Migrations\Migration;

class CreateDomiciliosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('domicilios', function ($table) {
            $table->increments('id');
            $table->string('calle', 100);
            $table->string('localidad', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('domicilios');
    }
}
