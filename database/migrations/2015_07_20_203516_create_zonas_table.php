<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('zonas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clave', 6);
            $table->decimal('km_maximos', 6, 2)->default(0.0);
            $table->unique('clave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('zonas');
    }
}
