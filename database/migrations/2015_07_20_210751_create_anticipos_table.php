<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnticiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('anticipos', function($table){
            $table->increments('id');
            $table->string('concepto', 50);
            $table->decimal('monto', 10, 2)->default(0.0)->unsigned();
            $table->boolean('cobrado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('anticipos');
    }
}
