<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIcecatCategoriesFeaturesConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('icecat_categories_features', function (Blueprint $table) {
            $table->unique(['icecat_category_feature_group_id', 'icecat_category_id', 'icecat_feature_id'], 'composite');
            $table->foreign('icecat_category_feature_group_id','category_features_group_foreign')->references('icecat_id')->on('icecat_categories');
            $table->foreign('icecat_category_id')->references('icecat_id')->on('icecat_categories');
            $table->foreign('icecat_feature_id')->references('icecat_id')->on('icecat_features');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('icecat_categories_features', function (Blueprint $table) {
            $table->dropForeign('icecat_categories_features_icecat_feature_id_foreign');
            $table->dropForeign('icecat_categories_features_icecat_category_id_foreign');
            $table->dropForeign('category_features_group_foreign');

            $table->dropUnique('composite');
        });
    }
}
