<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('productos', function ($table)
        {
            $table->increments('id');
            $table->boolean('activo')->default(true)->unsigned();
            $table->string('clave', 60);
            $table->string('descripcion', 300);
            $table->string('descripcion_corta', 50)->nullable();
            $table->timestamp('fecha_entrada');
            $table->string('numero_parte', 30);
            $table->boolean('remate')->default(false)->unsigned();
            $table->decimal('spiff', 14, 2);
            $table->string('subclave', 45);
            $table->integer('upc')->unsigned();
            $table->timestamps();
            $table->unique('clave');
            $table->unique('numero_parte');
            $table->unique('upc');
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
        Schema::drop('productos');
    }
}
