<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetDatabase extends Command
{

    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'reset:db
        { db_connection=mysql_testing : The database connection you want to run this command against. }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resets and migrates the database so we have a clean slate.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dbConnection = $this->argument('db_connection');
        $this->info('You are about to reset and migrate the database: ' . $dbConnection);
        $this->info('This action is destructive.');
        if ($this->confirm('Do you wish to continue? [y|N]')) {
            $this->call('migrate:reset', ['--database' => $dbConnection]);
            $this->call('migrate', ['--database' => $dbConnection]);
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
}
