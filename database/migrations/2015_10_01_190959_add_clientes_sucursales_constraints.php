<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientesSucursalesConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('clientes_sucursales', function ($table) {
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
        Schema::table('clientes_sucursales', function ($table) {
            $table->dropForeign('clientes_sucursales_cliente_id_foreign');
            $table->dropForeign('clientes_sucursales_sucursal_id_foreign');

            $table->dropColumn(['cliente_id', 'sucursal_id']);
        });
    }
}
