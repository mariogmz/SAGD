<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosContactoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_contacto', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 11)->nullable();
            $table->string('email', 45);
            $table->string('skype', 45)->nullable();
            $table->string('fotografia_url', 45)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('datos_contacto');
    }
}
