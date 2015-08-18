<?php

namespace App\Console\Commands;

use Illuminate\Database;
use Illuminate\Console\Command;
use Illuminate\Support\Facades as Facades;

class CleanDatabase extends Command
{

    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'db:clean
        { db_connection=mysql_testing : The database connection you want to run this command against. }
        { schema=sagd_test : The schema to be dropped and recreated. }
        { --force : Force the reset }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drops and recreates the database so we have a clean slate.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbConnection = $this->argument('db_connection');
        $schema = $this->argument('schema');
        $force = $this->option('force') ? true : false;

        if ($force) {
            $this->clean($dbConnection, $schema);
            return;
        }

        $this->info('You are about to fuck up the database: ' . $dbConnection. ' and schema: '. $schema);
        $this->info('This action is destructive.');

        if ($this->confirm('Do you wish to continue? [y|N]')) {
            $this->clean($dbConnection, $schema);
        }
    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        parent::__construct();
    }

    private function clean($dbConnection, $schema)
    {
        $dropStmt = "DROP SCHEMA ".$schema;
        $createStmt = "CREATE SCHEMA `".$schema."` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci";

        $conn = Facades\DB::connection($dbConnection);

        $this->getOutput()->writeln("\r<info>Drop:</info> Dropping schema <comment>". $schema . "</comment>");
        $conn->statement($dropStmt);

        $this->getOutput()->writeln("\r<info>Create:</info> Creating schema <comment>". $schema . "</comment>");
        $conn->statement($createStmt);

        $this->getOutput()->writeln("\r<info>Refresh:</info> Refreshing db");
        $conn->getPdo()->exec('use '.$schema);
        $this->call('db:reset', ['db_connection' => $dbConnection, '--force' => true]);
        // system('cd ~/Code/sagd && php artisan db:reset --force '.$dbConnection);
    }
}
