<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesToAllTables extends Migration
{

    protected $tables;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->getTables();
        $this->filterTables();
        foreach ($this->tables as $id => $table_name) {
            Schema::table($table_name, function ($table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->getTables();
        $this->filterTables();
        foreach ($this->tables as $id => $table_name) {
            Schema::table($table_name, function ($table) {
                $table->dropColumn('deleted_at');
            });
        }
    }

    private function getTables()
    {
        DB::connection('mysql');
        $this->tables = DB::select('show tables');
        DB::disconnect();
    }

    private function filterTables()
    {
        $this->tables = array_map(
            function($value){ return $value->Tables_in_sagd_local; },
            $this->tables
        );
        array_diff($this->tables, ['migrations']);
    }
}
