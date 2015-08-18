<?php

use Illuminate\Database\Migrations\Migration;

class CreateClientesComentariosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('clientes_comentarios', function ($table) {
            $table->increments('id');
            $table->string('comentario', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('clientes_comentarios');
    }
}
