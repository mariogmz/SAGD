<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductosConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('productos', function($table){
            $table->integer('tipo_garantia_id')->unsigned();
            $table->integer('marca_id')->unsigned();
            $table->integer('margen_id')->unsigned()->nullable();
            $table->integer('unidad_id')->unsigned();
            $table->integer('subfamilia_id')->unsigned();

            $table->foreign('tipo_garantia_id')->references('id')->on('tipos_garantias');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('margen_id')->references('id')->on('margenes');
            $table->foreign('unidad_id')->references('id')->on('unidades');
            $table->foreign('subfamilia_id')->references('id')->on('subfamilias');
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
        Schema::table('productos', function($table){
            $table->dropForeign('productos_tipo_garantia_id_foreign');
            $table->dropForeign('productos_marca_id_foreign');
            $table->dropForeign('productos_margen_id_foreign');
            $table->dropForeign('productos_unidad_id_foreign');
            $table->dropForeign('productos_subfamilia_id_foreign');

            $table->dropColumn(['subfamilia_id', 'marca_id', 'margen_id', 'unidad_id', 'tipo_garantia_id']);
        });
    }
}
