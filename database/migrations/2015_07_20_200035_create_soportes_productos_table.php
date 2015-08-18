<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSoportesProductosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('soportes_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad')->unsigned()->default(1);
            $table->decimal('precio', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('soportes_productos');
    }
}
