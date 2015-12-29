<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usuario', 20);
            $table->string('nombre', 200);
            $table->timestamp('fecha_nacimiento')->nullable();
            $table->enum('sexo',['MUJER','HOMBRE'])->nullable()->default('HOMBRE');
            $table->string('ocupacion', 45)->nullable();
            $table->timestamp('fecha_verificacion_correo')->nullable();
            $table->timestamp('fecha_expira_club_zegucom')->nullable();
            $table->string('referencia_otro', 50)->nullable();
            $table->timestamps();

            $table->unique('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('clientes');
    }
}
