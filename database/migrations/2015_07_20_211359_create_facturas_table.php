<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacturasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folio', 45);
            $table->timestamp('fecha_expedicion')->nullable();
            $table->timestamp('fecha_timbrado')->nullable();
            $table->longText('cadena_original_emisor');
            $table->longText('cadena_original_receptor');
            $table->boolean('error_sat')->default(false);
            $table->string('forma_pago', 60)->default('No identificado.');
            $table->string('metodo_pago', 60)->default('No identificado.');
            $table->string('numero_cuenta_pago', 60)->default('No identificado.');
            $table->mediumText('sello_digital_emisor');
            $table->mediumText('sello_digital_sat');
            $table->longText('xml');
            $table->string('lugar_expedicion', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('facturas');
    }
}
