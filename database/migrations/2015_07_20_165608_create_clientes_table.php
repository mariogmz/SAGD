<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('clientes', function($table){
            $table->increments('id');
            $table->string('email', 45);
            $table->string('usuario', 20);
            $table->char('password', 64);
            $table->string('nombre', 200);
            $table->timestamp('fecha_nacimiento')->nullable();
            $table->string('sexo', 15);
            $table->string('ocupacion', 45)->nullable();
            $table->timestamp('fecha_verificacion_correo')->nullable();
            $table->timestamp('fecha_expira_club_zegucom')->nullable();
            $table->string('referencia_otro', 50)->nullable();
            $table->integer('empleado_id')->nullable();
            $table->integer('vendedor_id')->nullable();
            $table->string('access_token', 20)->nullable();
            $table->timestamps();
            $table->unique('email');
            $table->unique('usuario');
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
        Schema::drop('clientes');
    }
}
