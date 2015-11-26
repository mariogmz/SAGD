<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntradasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('factura_externa_numero', 45);
            $table->timestamp('factura_fecha')->nullable();
            $table->string('moneda', 45);
            $table->decimal('tipo_cambio', 4, 2)->unsigned();
            $table->boolean('factura')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('entradas');
    }
}
