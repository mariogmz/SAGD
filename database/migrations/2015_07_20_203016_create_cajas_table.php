<?php

use Illuminate\Database\Migrations\Migration;

class CreateCajasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('cajas', function ($table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('mac_addr', 45);
            $table->char('token', 6);
            $table->integer('iteracion')->default(0);
            $table->unique('mac_addr');
            $table->unique('token');
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
        Schema::drop('cajas');
    }
}
