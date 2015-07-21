<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ventas', function($table){
            $table->increments('id');
            $table->decimal('total', 10, 2)->default(0.0)->nullable();
            $table->decimal('pago', 10, 2)->default(0.0)->nullable();
            $table->decimal('utilidad', 10, 2)->default(0.0)->nullable();
            $table->timestamp('fecha_cobro')->nullable();
            $table->integer('tabulador')->unsigned();
            $table->integer('empleado_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('ventas');
    }
}
