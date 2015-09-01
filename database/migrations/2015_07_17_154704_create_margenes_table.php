<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMargenesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('margenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->decimal('valor', 4, 3)->default(0.0);
            $table->decimal('valor_webservice_p1', 4, 3)->default(0.0);
            $table->decimal('valor_webservice_p8', 4, 3)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::drop('margenes');
    }
}
