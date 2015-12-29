<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTabuladoresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tabuladores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('valor')->unsigned();
            $table->integer('valor_original')->unsigned();
            $table->boolean('especial')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('tabuladores');
    }
}
