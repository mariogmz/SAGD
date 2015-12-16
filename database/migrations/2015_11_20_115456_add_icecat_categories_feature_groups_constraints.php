<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIcecatCategoriesFeatureGroupsConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('icecat_categories_feature_groups', function (Blueprint $table) {
            $table->unique('icecat_id');
            $table->unique(['icecat_category_id', 'icecat_feature_group_id'], 'composite');

            $table->foreign('icecat_category_id')->references('icecat_id')->on('icecat_categories');
            $table->foreign('icecat_feature_group_id')->references('icecat_id')->on('icecat_feature_groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('icecat_categories_feature_groups', function (Blueprint $table) {
            $table->dropForeign('icecat_categories_feature_groups_icecat_feature_group_id_foreign');
            $table->dropForeign('icecat_categories_feature_groups_icecat_category_id_foreign');

            $table->dropUnique('composite');
            $table->dropUnique('icecat_categories_feature_groups_icecat_id_unique');
        });
    }
}
