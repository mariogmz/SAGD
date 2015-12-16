<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIcecatCategoriesFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('icecat_categories_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('icecat_id')->unsigned();
            $table->integer('icecat_category_feature_group_id')->unsigned();
            $table->integer('icecat_category_id')->unsigned();
            $table->integer('icecat_feature_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('icecat_categories_features');
    }
}
