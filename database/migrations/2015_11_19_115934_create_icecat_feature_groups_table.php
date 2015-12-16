<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcecatFeatureGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('icecat_feature_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('icecat_id')->unsigned();
            $table->string('name', 70);
            $table->timestamps();

            $table->unique('icecat_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('icecat_feature_groups', function (Blueprint $table) {
            $table->dropUnique('icecat_feature_groups_icecat_id_unique');
        });
        Schema::drop('icecat_feature_groups');
    }
}
