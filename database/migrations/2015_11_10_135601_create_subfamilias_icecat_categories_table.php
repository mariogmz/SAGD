<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubfamiliasIcecatCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subfamilias_icecat_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subfamilia_id');
            $table->integer('icecat_categories_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('subfamilias_icecat_categories');
    }
}
