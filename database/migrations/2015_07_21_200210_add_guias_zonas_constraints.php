<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGuiasZonasConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('guias_zonas', function($table){
            $table->integer('guia_id')->unsigned();
            $table->integer('zonas_id')->unsigned();

            $table->foreign('guia_id')->references('id')->on('guias');
            $table->foreign('zonas_id')->references('id')->on('zonas');
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
        Schema::table('guias_zonas', function($table){
            $table->dropForeign('guias_zonas_guia_id_foreign');
            $table->dropForeign('guias_zonas_zona_id_foreign');

            $table->dropColumn(['zona_id', 'guia_id']);
        });
    }
}
