<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddConstraintsToFichasCaracteristicasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('fichas_caracteristicas', function (Blueprint $table) {
            $table->unique(['ficha_id', 'category_feature_id'], 'composite_unique');
            $table->foreign('ficha_id')->references('id')->on('fichas');
            $table->foreign('category_feature_id')->references('id')->on('icecat_categories_features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('fichas_caracteristicas', function (Blueprint $table) {
            $table->dropForeign('fichas_caracteristicas_category_feature_id_foreign');
            $table->dropForeign('fichas_caracteristicas_ficha_id_foreign');
            $table->dropUnique('composite_unique');
        });
    }
}
