<?php

use Illuminate\Database\Migrations\Migration;

class AddClientesAutorizacionesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('clientes_autorizaciones', function ($table) {
            $table->integer('cliente_id')->unsigned();
            $table->integer('cliente_autorizado_id')->unsigned()->nullable();

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('cliente_autorizado_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('clientes_autorizaciones', function ($table) {
            $table->dropForeign('clientes_autorizaciones_cliente_autorizado_id_foreign');
            $table->dropForeign('clientes_autorizaciones_cliente_id_foreign');

            $table->dropColumn(['cliente_id', 'cliente_autorizado_id']);
        });
    }
}
