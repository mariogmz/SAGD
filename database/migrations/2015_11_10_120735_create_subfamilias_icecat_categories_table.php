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
        Schema::create('subfamilias_icecat_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subfamilia_id')->unsigned();
            $table->integer('icecat_category_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
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
