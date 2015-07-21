<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApartadosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartados', function ($table)
        {
            // Foreign Key Fields
            $table->integer('estado_apartado_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('empleado_apartado_id')->unsigned();
            $table->integer('empleado_desapartado_id')->unsigned();
            // Constraints
            $table->foreign('estado_apartado_id')->references('id')->on('estados_apartados');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('empleado_apartado_id')->references('id')->on('empleados');
            $table->foreign('empleado_desapartado_id')->references('id')->on('empleados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartados', function ($table)
        {
            $table->dropForeign('apartados_estado_apartado_id_foreign');
            $table->dropForeign('apartados_sucursal_id_foreign');
            $table->dropForeign('apartados_empleado_apartado_id_foreign');
            $table->dropForeign('apartados_empleado_desapartado_id_foreign');
            $table->dropColumn(['estado_apartado_id', 'sucursal_id', 'empleado_apartado_id', 'empleado_desapartado_id']);
        });
    }
}
