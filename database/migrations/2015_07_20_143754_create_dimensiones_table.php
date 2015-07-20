<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimensionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dimensiones', function($table){
            $table->increments('id');
            $table->decimal('largo', 5, 2)->default(0.0)->unsigned();
            $table->decimal('ancho', 5, 2)->default(0.0)->unsigned();
            $table->decimal('alto', 5, 2)->default(0.0)->unsigned();
            $table->decimal('peso', 5, 2)->default(0.0)->unsigned();
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
        Schema::drop('dimensiones');
    }
}
