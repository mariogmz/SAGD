<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSucursalesConfiguracionesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sucursales_configuraciones', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('valor_numero', 10, 2)->nullable();
            $table->text('valor_texto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('sucursales_configuraciones');
    }
}
