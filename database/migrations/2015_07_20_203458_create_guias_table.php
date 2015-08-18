<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGuiasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('guias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 80)->nullable();
            $table->decimal('volumen_maximo', 10, 2);
            $table->decimal('ampara_hasta', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('guias');
    }
}
