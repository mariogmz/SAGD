<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaqueteriasRangosConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('paqueterias_rangos', function($table){
            $table->integer('paqueteria_id')->unsigned();
            $table->foreign('paqueteria_id')->references('id')->on('paqueterias');
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
        Schema::table('paqueterias_rangos', function($table){
            $table->dropForeign('paqueterias_rangos_paqueteria_id_foreign');
            $table->dropColumn('paqueteria_id');
        });
    }
}
