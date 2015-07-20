<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuiasZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias_zonas', function (Blueprint $table)
        {
            $table->increments('id');
            $table->decimal('costo', 10, 2)->default(0.0);
            $table->decimal('costo_sobrepeso', 10, 2)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('guias_zonas');
    }
}
