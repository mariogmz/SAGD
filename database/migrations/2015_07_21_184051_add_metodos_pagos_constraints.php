<?php

use Illuminate\Database\Migrations\Migration;

class AddMetodosPagosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::table('metodos_pagos', function ($table) {
            $table->integer('estatus_activo_id')->unsigned();
            $table->foreign('estatus_activo_id')->references('id')->on('estatus_activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::table('metodos_pagos', function ($table) {
            $table->dropForeign('metodos_pagos_estatus_activo_id_foreign');
            $table->dropColumn('estatus_activo_id');
        });
    }
}
