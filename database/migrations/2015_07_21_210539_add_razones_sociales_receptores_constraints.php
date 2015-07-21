<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRazonesSocialesReceptoresConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('razones_sociales_receptores', function ($table)
        {
            $table->integer('domicilio_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->foreign('domicilio_id')->references('id')->on('domicilios');
            $table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('razones_sociales_receptores', function ($table)
        {
            $table->dropForeign('razones_sociales_receptores_domicilio_id_foreign');
            $table->dropForeign('razones_sociales_receptores_cliente_id_foreign');
            $table->dropColumn(['domicilio_id', 'cliente_id']);
        });
    }
}
