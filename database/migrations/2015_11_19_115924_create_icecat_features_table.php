<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcecatFeaturesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('icecat_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('icecat_id')->unsigned();
            $table->string('type', 45)->nullable()->default('text');
            $table->string('name', 70);
            $table->string('description', 100)->nullable();
            $table->string('measure', 10)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('icecat_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('icecat_features', function (Blueprint $table) {
            $table->dropUnique('icecat_features_icecat_id_unique');
        });
        Schema::drop('icecat_features');
    }
}
