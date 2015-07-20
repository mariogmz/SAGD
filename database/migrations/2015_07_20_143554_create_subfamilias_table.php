<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubfamiliasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('subfamilias', function ($table)
        {
            $table->increments('id');
            $table->char('clave', 4);
            $table->string('nombre', 45);
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
        Schema::drop('subfamilias');
    }
}
