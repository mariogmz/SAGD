<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas', function (Blueprint $table){
            $table->increments('id');
            $table->integer('producto_id')->unsigned();
            $table->string('calidad', 45)->default('INTERNO');
            $table->string('titulo', 45);
            $table->boolean('revisada')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fichas');
    }
}
