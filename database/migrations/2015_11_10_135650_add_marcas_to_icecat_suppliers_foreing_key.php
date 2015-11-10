<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMarcasToIcecatSuppliersForeingKey extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('marcas', function (Blueprint $table) {
            $table->integer('icecat_supplier_id')->unsigned();
            $table->foreign('icecat_supplier_id')->references('id')->on('icecat_suppliers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('marcas', function (Blueprint $table) {
            $table->dropForeign('marcas_icecat_supplier_id_foreign');
            $table->dropColumn('icecat_supplier_id');
        });
    }
}
