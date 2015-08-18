<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRazonesSocialesEmisoresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('razones_sociales_emisores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rfc', 13);
            $table->string('regimen', 60);
            $table->string('serie', 3);
            $table->integer('ultimo_folio')->unsigned();
            $table->integer('numero_certificado')->unsigned();
            $table->integer('numero_certificado_sat')->unsigned();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('razones_sociales_emisores');
    }
}
