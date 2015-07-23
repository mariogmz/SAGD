<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarcasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('marcas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->char('clave', 3);
            $table->string('nombre', 25);
            $table->unique('clave');
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
        Schema::drop('marcas');
    }
}
