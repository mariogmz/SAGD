<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGuiasConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('guias', function($table){
            $table->integer('paqueteria_id')->unsigned();
            $table->integer('estatus_activo_id')->unsigned();

            $table->foreign('paqueteria_id')->references('id')->on('paqueterias');
            $table->foreign('estatus_activo_id')->references('id')->on('estatus_activo');
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
        Schema::table('guias', function($table){
            $table->dropForeign('guias_paqueteria_id_foreign');
            $table->dropForeign('guias_estatus_activo_id_foreign');

            $table->dropColumn(['estatus_activo_id', 'paqueteria_id']);
        });
    }
}
