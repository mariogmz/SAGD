<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('factura_externa_numero',45);
            $table->nullableTimestamps('factura_fecha');
            $table->string('moneda',45);
            $table->decimal('tipo_cambio',4,2)->unsigned();
            $table->integer('estado_entrada_id');
            $table->integer('proveedor_id');
            $table->integer('razon_social_id');
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
    }
}
