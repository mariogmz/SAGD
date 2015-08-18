<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicioSoporteTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('servicio_soporte', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion_equipo', 100);
            $table->string('falla', 100);
            $table->string('solucion', 100)->nullable();
            $table->decimal('costo', 14, 2)->default(0);
            $table->timestamp('fecha_recepcion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('fecha_entrega')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('servicio_soporte');
    }
}
