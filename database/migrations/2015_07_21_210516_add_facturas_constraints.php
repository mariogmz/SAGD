<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacturasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function ($table)
        {
            // Foreign Key Fields
            $table->integer('corte_global_id')->unsigned();
            $table->integer('caja_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            // Constraints
            $table->foreign('corte_global_id')->references('id')->on('cortes');
            $table->foreign('caja_id')->references('id')->on('cajas');
            $table->foreign('empleado_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function ($table)
        {
            $table->dropForeign('facturas_corte_global_id_foreign');
            $table->dropForeign('facturas_caja_id_foreign');
            $table->dropForeign('facturas_empleado_id_foreign');
            $table->dropColumn(['corte_global_id', 'caja_id', 'empleado_id']);
        });
    }
}