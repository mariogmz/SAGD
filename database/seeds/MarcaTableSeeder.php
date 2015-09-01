<?php

use Illuminate\Database\Seeder;

class MarcaTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $marcasLegacy;
    protected $counter;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $this->setUpLegacyConnection();
        $this->getTotalCount();
        $this->getMarcas();
        $this->createMarcas();
    }

    private function setUpLegacyConnection() {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalCount() {
        $statement = "SELECT count(*) as count FROM marcas;";
        $this->totalData = $this->legacy->selectOne($statement)->count;
    }

    private function getMarcas() {
        $statement = "SELECT Clave as clave, Marca as marca FROM marcas;";
        $this->marcasLegacy = $this->legacy->select($statement);
    }

    private function createMarcas() {
        $this->counter = 0;
        foreach ($this->marcasLegacy as $marcaLegacy) {
            $marca = ['clave' => strtoupper($marcaLegacy->clave), 'nombre' => $marcaLegacy->marca];
            DB::table('marcas')->insert($marca);
            $this->counter ++;
            $this->printProgress();
        }
        echo "\n";
    }

    private function printProgress() {
        $progress = sprintf("%01.2f%%", ($this->counter / $this->totalData) * 100);
        if ($progress <= 0.01) {
            $progress = 0.01;
        }
        $this->command->getOutput()->write("\r<info>Seeding:</info> Marca <comment>" . $progress . "</comment>");
    }

    private function printDebug($what, $params) {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln(sprintf("\n<question>%s</question> <info>%s</info>", $what, $param));
        }
    }
}
