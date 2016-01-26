<?php

use Illuminate\Database\Seeder;

class IcecatModuleSeeder extends Seeder
{
    private $database;
    private $username;
    private $password;

    private $dataPath = 'icecat_module_seed.sql';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->dumpExists()) {
            $this->restoreDump();
        } else {
            if($this->command->confirm('Do you want to seed Icecat database? This may take a very long time to complete.', false)){
                $this->call(IcecatFeatureTableSeeder::class);
                $this->call(IcecatSupplierTableSeeder::class);
                $this->call(IcecatCategoryTableSeeder::class);
                $this->call(IcecatFeatureGroupTableSeeder::class);
                $this->call(IcecatCategoryFeatureGroupTableSeeder::class);
                $this->call(IcecatCategoryFeatureTableSeeder::class);
            }
        }
    }

    private function dumpExists()
    {
        return file_exists($this->dataPath);
    }

    private function restoreDump()
    {
        $this->getConfig();
        $command = sprintf("mysql --database=%s --user=%s --password=%s < %s",
            $this->database,
            $this->username,
            $this->password,
            $this->dataPath);
        exec($command);
    }

    private function getConfig()
    {
        if (app()->environment() === 'local') {
            $this->database = getenv('DB_DATABASE');
            $this->username = getenv('DB_USERNAME');
            $this->password = getenv('DB_PASSWORD');
        } else {
            $this->database = getenv('TEST_DB_DATABASE');
            $this->username = getenv('TEST_DB_USERNAME');
            $this->password = getenv('TEST_DB_PASSWORD');
        }

    }
}
