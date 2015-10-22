<?php

use Illuminate\Database\Migrations\Migration;

class AddDescuentoToPreciosTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('precios', function ($table) {
            $table->decimal('descuento', 3, 2)->nullable()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('precios', function ($table) {
            $table->dropColumn('descuento');
        });
    }
}
