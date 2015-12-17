<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGaleriasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('galerias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ficha_id')->unsigned();
            $table->boolean('principal')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('ficha_id')->references('id')->on('fichas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('galerias', function (Blueprint $table) {
            $table->dropForeign('galerias_ficha_id_foreign');
        });

        Schema::drop('galerias');
    }
}
