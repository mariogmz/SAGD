<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRazonesSocialesReceptoresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('razones_sociales_receptores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rfc', 13)->nullable();
            $table->string('regimen', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('razones_sociales_receptores');
    }
}
