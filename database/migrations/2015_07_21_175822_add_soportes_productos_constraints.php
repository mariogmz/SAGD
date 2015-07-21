<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoportesProductosConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('soportes_productos', function($table){
            $table->integer('soporte_id')->unsigned();
            $table->integer('producto_id')->unsigned();

            $table->foreign('soporte_id')->references('id')->on('servicio_soporte')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
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
        Schema::table('soportes_productos', function($table){
            $table->dropForeign('soportes_productos_soporte_id_foreign');
            $table->dropForeign('soportes_productos_producto_id_foreign');
            
            $table->dropColumn(['producto_id', 'soporte_id']);
        });
    }
}
