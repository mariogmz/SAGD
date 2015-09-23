<?php

use Illuminate\Database\Migrations\Migration;

class AddSubfamiliasConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('subfamilias', function ($table) {
            $table->integer('familia_id')->unsigned();
            $table->integer('margen_id')->unsigned()->nullable();

            $table->foreign('familia_id')->references('id')->on('familias');
            $table->foreign('margen_id')->references('id')->on('margenes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('subfamilias', function ($table) {
            $table->dropForeign('subfamilias_familia_id_foreign');
            $table->dropForeign('subfamilias_margen_id_foreign');

            $table->dropColumn(['familia_id', 'margen_id']);
        });
    }
}
