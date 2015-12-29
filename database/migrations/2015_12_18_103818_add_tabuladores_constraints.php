<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTabuladoresConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('tabuladores', function (Blueprint $table) {
            $table->integer('cliente_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();

            $table->unique(['cliente_id', 'sucursal_id']);

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('tabuladores', function (Blueprint $table) {
            $table->dropForeign('tabuladores_sucursal_id_foreign');
            $table->dropForeign('tabuladores_cliente_id_foreign');

            $table->dropUnique('tabuladores_cliente_id_sucursal_id_unique');

            $table->dropColumn('sucursal_id');
            $table->dropColumn('cliente_id');
        });
    }
}
