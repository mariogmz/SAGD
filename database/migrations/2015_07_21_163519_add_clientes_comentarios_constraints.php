<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientesComentariosConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('clientes_comentarios', function($table){
            $table->integer('cliente_id')->unsigned();
            $table->integer('empleado_id')->unsigned();

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::table('clientes_comentarios', function($table){
            $table->dropForeign('clientes_comentarios_cliente_id_foreign');
            $table->dropForeign('clientes_comentarios_empleado_id_foreign');

            $table->dropColumn(['cliente_id', 'empleado_id']);
        });
    }
}
