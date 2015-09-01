<?php

use Illuminate\Database\Migrations\Migration;

class CreateGastosExtrasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('gastos_extras', function ($table) {
            $table->increments('id');
            $table->decimal('monto', 10, 2);
            $table->string('concepto', 45);
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
        Schema::drop('gastos_extras');
    }
}
