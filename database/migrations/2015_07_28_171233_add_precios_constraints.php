<?php

use Illuminate\Database\Migrations\Migration;

class AddPreciosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('precios', function ($table) {
            $table->integer('producto_sucursal_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('precios', function ($table) {
            $table->dropColumn('producto_sucursal_id');
        });
    }
}
