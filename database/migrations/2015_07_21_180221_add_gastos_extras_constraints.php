<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGastosExtrasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gastos_extras', function ($table)
        {
            // Foreign Key Fields
            $table->integer('caja_id')->unsigned();
            $table->integer('corte_id')->unsigned();
            // Constraints
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->foreign('corte_id')->references('id')->on('cortes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gastos_extras', function ($table){
            $table->dropForeign('gastos_extras_caja_id_foreign');
            $table->dropForeign('gastos_extras_corte_id_foreign');
            $table->dropColumn(['caja_id','corte_id']);
        });
    }
}
