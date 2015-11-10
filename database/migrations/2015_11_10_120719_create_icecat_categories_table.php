<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcecatCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('icecat_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('icecat_id')->unsigned();
            $table->string('name', 100);
            $table->string('description', 300)->nullable();
            $table->string('keyword', 100)->nullable();
            $table->integer('icecat_parent_category_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('icecat_categories');
    }
}
