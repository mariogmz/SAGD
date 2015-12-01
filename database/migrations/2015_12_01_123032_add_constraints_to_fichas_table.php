<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConstraintsToFichasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fichas', function (Blueprint $table){
            $table->unique('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fichas_caracteristicas', function (Blueprint $table){
            $table->dropForeign('fichas_caracteristicas_producto_id_foreign');
            $table->dropUnique('fichas_caracteristicas_producto_id_unique');
        });
    }
}
