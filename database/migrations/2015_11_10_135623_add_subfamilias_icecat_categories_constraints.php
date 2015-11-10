<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSubfamiliasIcecatCategoriesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subfamilias_icecat_categories', function (Blueprint $table) {
            $table->foreign('subfamilia_id')->references('id')->on('subfamilias');
            $table->foreign('icecat_category_id')->references('id')->on('icecat_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('subfamilias_icecat_categories', function (Blueprint $table) {
            $table->dropForeign('subfamilias_icecat_categories_subfamilia_id_foreign');
            $table->dropForeign('subfamilias_icecat_categories_icecat_category_id_foreign');
        });
    }
}
