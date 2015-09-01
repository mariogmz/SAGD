<?php

use Illuminate\Database\Migrations\Migration;

class CreateGarantiasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('garantias', function ($table) {
            $table->increments('id');
            $table->string('serie', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('garantias');
    }
}
