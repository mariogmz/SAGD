<?php

use Illuminate\Database\Migrations\Migration;

class CreateVentasDetallesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('ventas_detalles', function ($table) {
            $table->increments('id');
            $table->integer('cantidad')->default(1)->unsigned();
            $table->string('descripcion', 50)->nullable();
            $table->decimal('precio', 10, 2)->default(0.0);
            $table->decimal('total', 10, 2)->default(0.0);
            $table->decimal('utilidad', 10, 2)->default(0.0);
            $table->timestamp('fecha_expiracion_garantia')->nullable();
            $table->integer('tiempo_garantia')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('ventas_detalles');
    }
}
