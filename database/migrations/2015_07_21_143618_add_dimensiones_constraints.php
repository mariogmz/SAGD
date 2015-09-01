<?php

use Illuminate\Database\Migrations\Migration;

class AddDimensionesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('dimensiones', function ($table) {
            $table->integer('producto_id')->unsigned();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('dimensiones', function ($table) {
            $table->dropForeign('dimensiones_producto_id_foreign');
            $table->dropColumn('producto_id');
        });
    }
}
