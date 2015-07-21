<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSucursalesConfiguracionesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sucursales_configuraciones', function ($table)
        {
            // Foreign Key Fields
            $table->integer('sucursal_id')->unsigned();
            $table->integer('configuracion_id')->unsigned();
            // Constraints
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
            $table->foreign('configuracion_id')->references('id')->on('configuraciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sucursales_configuraciones', function ($table)
        {
            $table->dropForeign('sucursales_configuraciones_sucursal_id_foreign');
            $table->dropForeign('sucursales_configuraciones_configuracion_id_foreign');
        });
    }
}
