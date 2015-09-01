<?php

use Illuminate\Database\Seeder;

class PaqueteriaRangoTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $rangosLegacy;
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
        $this->getRangosLegacy();
        $this->createRangos();
    }

    private function setUpLegacyConnection() {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalCount() {
        $statement = "SELECT count(rango0_20) as count, rango20_40, rango40_60, rango60_80, rango80_100 FROM paqueteria;";
        $rows = $this->legacy->selectOne($statement)->count;
        $columns = count(get_object_vars($this->legacy->selectOne($statement)));
        $this->totalData = $rows * $columns;
    }

    private function getRangosLegacy() {
        $statement = "SELECT clave, rango0_20, rango20_40, rango40_60, rango60_80, rango80_100 FROM paqueteria;";
        $this->rangosLegacy = $this->legacy->select($statement);
    }

    private function createRangos() {
        $this->counter = 0;
        foreach ($this->rangosLegacy as $rangoLegacy) {
            $paqueteria = App\Paqueteria::where('clave', $rangoLegacy->clave)->first();
            $rangos = [];
            array_push($rangos, ['paqueteria_id' => $paqueteria->id, 'distribuidor' => 0, 'desde' => 0.0, 'hasta' => 0.20, 'valor' => ($rangoLegacy->rango0_20 / 100.0)]);
            array_push($rangos, ['paqueteria_id' => $paqueteria->id, 'distribuidor' => 0, 'desde' => 0.21, 'hasta' => 0.40, 'valor' => ($rangoLegacy->rango20_40 / 100.0)]);
            array_push($rangos, ['paqueteria_id' => $paqueteria->id, 'distribuidor' => 0, 'desde' => 0.41, 'hasta' => 0.60, 'valor' => ($rangoLegacy->rango40_60 / 100.0)]);
            array_push($rangos, ['paqueteria_id' => $paqueteria->id, 'distribuidor' => 0, 'desde' => 0.61, 'hasta' => 0.80, 'valor' => ($rangoLegacy->rango60_80 / 100.0)]);
            array_push($rangos, ['paqueteria_id' => $paqueteria->id, 'distribuidor' => 0, 'desde' => 0.81, 'hasta' => 1.00, 'valor' => ($rangoLegacy->rango80_100 / 100.0)]);
            foreach ($rangos as $rango) {
                DB::table('paqueterias_rangos')->insert($rango);
                $this->counter ++;
                $this->printProgress();
            }
        }
        echo "\n";
    }

    private function printProgress() {
        $progress = sprintf("%01.2f%%", ($this->counter / $this->totalData) * 100);
        if ($progress <= 0.01) {
            $progress = 0.01;
        }
        $this->command->getOutput()->write("\r<info>Seeding:</info> PaqueteriaRango <comment>" . $progress . "</comment>");
    }

    private function printDebug($what, $params) {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln(sprintf("\n<question>%s</question> <info>%s</info>", $what, $param));
        }
    }
}
