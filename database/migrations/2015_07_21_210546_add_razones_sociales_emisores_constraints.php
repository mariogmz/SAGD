<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRazonesSocialesEmisoresConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('razones_sociales_emisores', function($table)
        {
            $table->integer('domicilio_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->foreign('domicilio_id')->references('id')->on('domicilios');
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
        Schema::table('razones_sociales_emisores', function($table)
        {
            $table->dropForeign('razones_sociales_emisores_domicilio_id_foreign');
            $table->dropForeign('razones_sociales_emisores_sucursal_id_foreign');
            $table->dropColumn('domicilio_id');
            $table->dropColumn('sucursal_id');
        });
    }
}
