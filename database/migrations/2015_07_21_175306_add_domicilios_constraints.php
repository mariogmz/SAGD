<?php

use Illuminate\Database\Migrations\Migration;

class AddDomiciliosConstraints extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('domicilios', function ($table)
        {
            $table->integer('codigo_postal_id')->unsigned();
            $table->integer('telefono_id')->unsigned();
            $table->foreign('codigo_postal_id')->references('id')->on('codigos_postales');
            $table->foreign('telefono_id')->references('id')->on('telefonos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('domicilios', function ($table)
        {
            $table->dropForeign('domicilios_codigo_postal_id_foreign');
            $table->dropForeign('domicilios_telefono_id_foreign');
            $table->dropColumn(['codigo_postal_id', 'telefono_id']);
        });
    }
}
