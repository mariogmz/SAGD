<?php

use Illuminate\Database\Seeder;

class FamiliaTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $familiasLegacy;
    protected $counter;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $this->setUpLegacyConnection();
        $this->getTotalData();
        $this->getFamiliasLegacy();
        $this->createFamilias();
    }

    private function setUpLegacyConnection() {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalData() {
        $statement = "SELECT count(*) as count FROM familias;";
        $this->totalData = $this->legacy->selectOne($statement)->count;
    }

    private function getFamiliasLegacy() {
        $statement = "SELECT CLAVEFAM as clave, FAMILIA as nombre, DESCRIPCION as descripcion FROM familias";
        $this->familiasLegacy = $this->legacy->select($statement);
    }

    private function createFamilias() {
        $this->counter = 0;
        foreach ($this->familiasLegacy as $familiaLegacy) {
            DB::table('familias')->insert([
                'clave'       => $familiaLegacy->clave,
                'nombre'      => $familiaLegacy->nombre,
                'descripcion' => $familiaLegacy->descripcion
            ]);
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
        $this->command->getOutput()->write("\r<info>Seeding:</info> Familia <comment>" . $progress . "</comment>");
    }

    private function printDebug($what, $params) {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln(sprintf("\n<question>%s</question> <info>%s</info>", $what, $param));
        }
    }
}
