<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnticiposConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('anticipos', function($table){
            $table->integer('venta_id')->unsigned();
            $table->integer('venta_entrega_id')->unsigned()->nullable();

            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->foreign('venta_entrega_id')->references('id')->on('ventas');
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
        Schema::table('anticipos', function($table){
            $table->dropForeign('anticipos_venta_id_foreign');
            $table->dropForeign('anticipos_venta_entrega_id_foreign');

            $table->dropColumn(['venta_id', 'venta_entrega_id']);
        });
    }
}
