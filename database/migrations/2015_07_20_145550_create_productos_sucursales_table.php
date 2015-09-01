<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductosSucursalesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('productos_sucursales', function ($table) {
            $table->increments('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('productos_sucursales');
    }
}
