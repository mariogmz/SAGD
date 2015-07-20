<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCortesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cortes', function($table){
            $table->increments('id');
            $table->decimal('fondo', 10, 2);
            $table->decimal('fondo_reportado', 10, 2)->nullable();
            $table->integer('caja_id')->nullable();
            $table->integer('caja_corte_global')->nullable();
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
        Schema::drop('cortes');
    }
}
