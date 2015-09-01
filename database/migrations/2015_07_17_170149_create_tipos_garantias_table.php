<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposGarantiasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('tipos_garantias', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('seriado')->unsigned()->default(1);
            $table->string('descripcion', 45);
            $table->integer('dias')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('tipos_garantias');
    }
}
