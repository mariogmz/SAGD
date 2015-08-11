<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntradasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entradas', function ($table)
        {
            // Foreign Key Fields
            $table->integer('estado_entrada_id')->unsigned();
            $table->integer('proveedor_id')->unsigned();
            $table->integer('razon_social_id')->unsigned();
            $table->integer('empleado_id')->unsigned();
            // Constraints
            $table->foreign('estado_entrada_id')->references('id')->on('estados_entradas');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('razon_social_id')->references('id')->on('razones_sociales_emisores');
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
        Schema::table('entradas', function ($table)
        {
            $table->dropForeign('entradas_estado_entrada_id_foreign');
            $table->dropForeign('entradas_proveedor_id_foreign');
            $table->dropForeign('entradas_razon_social_id_foreign');
            $table->dropForeign('entradas_empleado_id_foreign');
            $table->dropColumn(['estado_entrada_id', 'proveedor_id', 'razon_social_id', 'empleado_id']);
        });
    }
}
