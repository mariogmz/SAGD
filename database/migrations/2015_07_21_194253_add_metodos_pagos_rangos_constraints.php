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
            $table->integer('metodos_pagos_id')->unsigned();
            $table->foreign('metodos_pagos_id')->references('id')->on('metodos_pagos');
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
            $table->dropForeign('metodos_pagos_rangos_metodos_pagos_id_foreign');
            $table->dropColumn('metodos_pagos_id');
        });
    }
}
