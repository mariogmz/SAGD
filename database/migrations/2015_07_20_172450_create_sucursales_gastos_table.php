<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSucursalesGastosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sucursales_gastos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('diario', 14, 2);
            $table->decimal('mensual', 14, 2);
            $table->decimal('extraordinario', 14, 2);
            $table->decimal('meta_mensual', 14, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sucursales_gastos');
    }
}
