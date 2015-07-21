<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaqueteriasCoberturasConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('paqueterias_coberturas', function($table){
            $table->integer('paqueteria_id')->unsigned();
            $table->integer('codigo_postal_id')->unsigned();

            $table->foreign('paqueteria_id')->references('id')->on('paqueterias');
            $table->foreign('codigo_postal_id')->references('id')->on('codigos_postales');
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
        Schema::table('paqueterias_coberturas', function($table){
            $table->dropForeign('paqueterias_coberturas_paqueteria_id_foreign');
            $table->dropForeign('paqueterias_coberturas_codigo_postal_id_foreign');

            $table->dropColumn(['codigo_postal_id', 'paqueteria_id']);
        });
    }
}
