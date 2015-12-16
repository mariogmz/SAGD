<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIcecatCategoriesConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('icecat_categories', function (Blueprint $table) {
            $table->unique('icecat_id');
            $table->foreign('icecat_parent_category_id')->references('icecat_id')->on('icecat_categories');
            $table->foreign('subfamilia_id')->references('id')->on('subfamilias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('icecat_categories', function (Blueprint $table) {
            $table->dropForeign('icecat_categories_icecat_parent_category_id_foreign');
            $table->dropForeign('icecat_categories_subfamilia_id_foreign');
            $table->dropUnique('icecat_categories_icecat_id_unique');
        });
    }
}
