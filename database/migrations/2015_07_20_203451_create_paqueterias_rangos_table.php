<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaqueteriasRangosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paqueterias_rangos', function (Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('desde', 3, 2)->default(0.0);
            $table->decimal('hasta', 3, 2)->default(0.0);
            $table->decimal('valor', 3, 2)->default(0.0);
            $table->boolean('distribuidor')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paqueterias_rangos');
    }
}
