<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemoveNumeroParteUniqueConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropUnique('productos_numero_parte_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('productos', function (Blueprint $table) {
            $table->unique('numero_parte');
        });
    }
}
