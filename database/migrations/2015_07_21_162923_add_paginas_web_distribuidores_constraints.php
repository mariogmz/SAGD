<?php

use Illuminate\Database\Migrations\Migration;

class AddPaginasWebDistribuidoresConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('paginas_web_distribuidores', function ($table) {
            $table->integer('cliente_id')->unsigned();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('paginas_web_distribuidores', function ($table) {
            $table->dropForeign('paginas_web_distribuidores_cliente_id_foreign');
            $table->dropColumn('cliente_id');
        });
    }
}
