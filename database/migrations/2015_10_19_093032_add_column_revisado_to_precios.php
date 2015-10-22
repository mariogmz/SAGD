<?php

use Illuminate\Database\Migrations\Migration;

class AddColumnRevisadoToPrecios extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('precios', function ($table) {
           $table->boolean('revisado')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('precios', function($table){
           $table->dropColumn('revisado');
        });
    }
}
