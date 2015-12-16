<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTimestampsSoftDeletesToFichasAndCaracteristicasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('fichas', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('fichas_caracteristicas', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('fichas_caracteristicas', function (Blueprint $table) {
            $table->dropTimestamps();
        });
        Schema::table('fichas', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
