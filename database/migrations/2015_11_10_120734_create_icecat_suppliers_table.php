<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcecatSuppliersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('icecat_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('icecat_id')->unsigned();
            $table->string('name', 50);
            $table->string('logo_url', 100)->nullable();
            $table->integer('marca_id')->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('icecat_suppliers');
    }
}
