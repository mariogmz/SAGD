<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddImagenFieldsToGaleriasTable extends Migration {

    /**
     * Make changes to the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('galerias', function(Blueprint $table) {

            $table->string('imagen_file_name')->nullable();
            $table->integer('imagen_file_size')->nullable()->after('imagen_file_name');
            $table->string('imagen_content_type')->nullable()->after('imagen_file_size');
            $table->timestamp('imagen_updated_at')->nullable()->after('imagen_content_type');

        });

    }

    /**
     * Revert the changes to the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('galerias', function(Blueprint $table) {

            $table->dropColumn('imagen_file_name');
            $table->dropColumn('imagen_file_size');
            $table->dropColumn('imagen_content_type');
            $table->dropColumn('imagen_updated_at');

        });
    }

}