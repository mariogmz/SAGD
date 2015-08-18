<?php

use Illuminate\Database\Migrations\Migration;

class CreatePreciosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('precios', function ($table) {
            $table->increments('id');
            $table->decimal('costo', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_1', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_2', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_3', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_4', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_5', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_6', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_7', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_8', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_9', 14, 4)->default(0.0)->unsigned();
            $table->decimal('precio_10', 14, 4)->default(0.0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('precios');
    }
}
