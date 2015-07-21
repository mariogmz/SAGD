<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransferenciasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferencias', function ($table)
        {
            // Foreign Key Fields
            $table->integer('sucursal_origen_id')->unsigned();
            $table->integer('sucursal_destino_id')->unsigned();
            $table->integer('empleado_origen_id')->unsigned();
            $table->integer('empleado_destino_id')->unsigned();
            $table->integer('empleado_revision_id')->unsigned();
            $table->integer('estado_transferencia_id')->unsigned();
            // Constraints
            $table->foreign('sucursal_origen_id')->references('id')->on('sucursales');
            $table->foreign('sucursal_destino_id')->references('id')->on('sucursales');
            $table->foreign('empleado_origen_id')->references('id')->on('empleados');
            $table->foreign('empleado_destino_id')->references('id')->on('empleados');
            $table->foreign('empleado_revision_id')->references('id')->on('empleados');
            $table->foreign('estado_transferencia_id')->references('id')->on('estados_transferencias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transferencias', function ($table)
        {
            $table->dropForeign('transferencias_sucursal_origen_id_foreign');
            $table->dropForeign('transferencias_sucursal_destino_id_foreign');
            $table->dropForeign('transferencias_empleado_origen_id_foreign');
            $table->dropForeign('transferencias_empleado_destino_id_foreign');
            $table->dropForeign('transferencias_empleado_revision_id_foreign');
            $table->dropForeign('transferencias_estado_transferencia_id_foreign');
            $table->dropColumn(['sucursal_destino_id', 'sucursal_origen_id', 'empleado_origen_id', 'empleado_destino_id',
                'estado_transferencia_id', 'empleado_revision_id']);
        });
    }
}
