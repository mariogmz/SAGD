<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasDetallesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas_detalles', function (Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('costo', 10, 2)->default(0.0);
            $table->integer('cantidad')->default('1');
            $table->decimal('importe', 10, 2);
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
        Schema::drop('entradas_detalles');
    }
}