<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('productos_movimientos', function($table){
            $table->increments('id');
            $table->string('movimiento', 100);
            $table->integer('entraron')->default(0)->unsigned();
            $table->integer('salieron')->default(0)->unsigned();
            $table->integer('existencias_antes')->default(0)->unsigned();
            $table->integer('existencias_despues')->default(0)->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('productos_movimientos');
    }
}
