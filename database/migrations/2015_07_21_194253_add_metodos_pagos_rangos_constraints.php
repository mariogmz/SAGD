<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetodosPagosRangosConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('metodos_pagos_rangos', function($table){
            $table->integer('metodo_pago_id')->unsigned();
            $table->foreign('metodo_pago_id')->references('id')->on('metodos_pagos');
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
        Schema::table('metodos_pagos_rangos', function($table){
            $table->dropForeign('metodos_pagos_rangos_metodo_pago_id_foreign');
            $table->dropColumn('metodo_pago_id');
        });
    }
}
