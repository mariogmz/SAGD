<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('familias', function(Blueprint $table) {
            $table->increments('id');
            $table->char('clave', 4);
            $table->string('nombre', 45);
            $table->string('descripcion', 100)->nullable();
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
        Schema::drop('familias');
    }
}
