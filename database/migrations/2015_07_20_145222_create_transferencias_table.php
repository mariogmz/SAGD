<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransferenciasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('fecha_transferencia')->nullable();
            $table->timestamp('fecha_recepcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('transferencias');
    }
}
