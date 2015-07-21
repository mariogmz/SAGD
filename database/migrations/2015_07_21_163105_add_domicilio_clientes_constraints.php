<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDomicilioClientesConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('domicilios_clientes', function($table){
            $table->integer('domicilio_id')->unsigned();
            $table->integer('cliente_id')->unsigned();

            $table->foreign('domicilio_id')->references('id')->on('domicilios')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
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
        Schema::table('domicilios_clientes', function($table){
            $table->dropForeign('domicilios_clientes_domicilio_id_foreign');
            $table->dropForeign('domicilios_clientes_cliente_id_foreign');

            $table->dropColumn(['domicilio_id', 'cliente_id']);
        });
    }
}
