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
            $table->integer('razon_social_emisor_id')->unsigned();
            $table->integer('razon_social_receptor_id')->unsigned();
            $table->integer('factura_status_id')->unsigned();
            // Constraints
            $table->foreign('razon_social_emisor_id')->references('id')->on('razones_sociales_emisores');
            $table->foreign('razon_social_receptor_id')->references('id')->on('razones_sociales_receptores');
            $table->foreign('factura_status_id')->references('id')->on('estados_facturas');
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
            $table->dropForeign('facturas_razon_social_emisor_id_foreign');
            $table->dropForeign('facturas_razon_social_receptor_id_foreign');
            $table->dropForeign('facturas_factura_status_id_foreign');
            $table->dropColumn(['razon_social_emisor_id', 'razon_social_receptor_id', 'factura_status_id']);
        });
    }
}
