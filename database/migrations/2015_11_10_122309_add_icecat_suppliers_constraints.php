<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIcecatSuppliersConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('icecat_suppliers', function (Blueprint $table) {
            $table->unique('icecat_id');
            $table->unique('name');
            $table->foreign('marca_id')->references('id')->on('marcas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('icecat_suppliers', function (Blueprint $table) {
            $table->dropUnique('icecat_id');
            $table->dropUnique('name');
            $table->dropForeign('icecat_suppliers_marca_id_foreign');
        });
    }
}
