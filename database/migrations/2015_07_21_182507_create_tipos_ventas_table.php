<?php

use Illuminate\Database\Migrations\Migration;

class CreateTiposVentasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('tipos_ventas', function ($table) {
            $table->increments('id');
            $table->string('nombre', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('tipos_ventas');
    }
}
