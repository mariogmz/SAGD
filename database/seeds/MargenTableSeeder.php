<?php

use Illuminate\Database\Seeder;

class MargenTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $counter;
    protected $categoriasLegacy;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $this->setUpLegacyConnection();
        $this->getTotalData();
        $this->getCategorias();
        $this->createMargenes();
    }

    private function setUpLegacyConnection() {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalData() {
        $statement = "SELECT count(*) as count FROM categorias;";
        $this->totalData = $this->legacy->selectOne($statement)->count;
    }

    private function getCategorias() {
        $statement = "SELECT * FROM categorias ORDER BY clave;";
        $this->categoriasLegacy = $this->legacy->select($statement);
    }

    private function createMargenes() {
        $this->counter = 0;
        foreach ($this->categoriasLegacy as $categoria) {
            $data = [
                'nombre'              => $categoria->categoria,
                'valor'               => $categoria->margen / 100,
                'valor_webservice_p1' => $categoria->margen_precio1 / 100,
                'valor_webservice_p8' => $categoria->margen_webservice / 100
            ];
            DB::table('margenes')->insert($data);
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
        $this->command->getOutput()->write("\r<info>Seeding:</info> Margen <comment>" . $progress . "</comment>");
    }

    private function printDebug($what, $params) {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln(sprintf("\n<question>%s</question> <info>%s</info>", $what, $param));
        }
    }
}
