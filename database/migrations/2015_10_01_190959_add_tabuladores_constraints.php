<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTabuladoresConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('tabuladores', function ($table) {
            $table->integer('cliente_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
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
        Schema::table('tabuladores', function ($table) {
            $table->dropForeign('tabuladores_cliente_id_foreign');
            $table->dropForeign('tabuladores_sucursal_id_foreign');

            $table->dropColumn(['cliente_id', 'sucursal_id']);
        });
    }
}
