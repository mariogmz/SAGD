<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaqueteriasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paqueterias', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('clave', 6);
            $table->string('nombre', 45);
            $table->string('url', 100)->nullable();
            $table->string('horario', 60)->nullable();
            $table->string('condicion_entrega', 100)->nullable();
            $table->decimal('seguro', 3, 2)->default(0.0)->unsigned();
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
        Schema::drop('paqueterias');
    }
}
