<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTelefonosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('telefonos', function (Blueprint $table) {
            $table->integer('domicilio_id')->unsigned();
            $table->foreign('domicilio_id')->references('id')->on('domicilios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('telefonos', function (Blueprint $table) {
            $table->dropForeign('telefonos_domicilio_id_foreign');
            $table->dropColumn('domicilio_id');
        });
    }
}
