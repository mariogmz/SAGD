<?php

use Illuminate\Database\Seeder;

class SubfamiliaTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $counter;
    protected $subfamiliasLegacy;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        $this->setUpLegacyConnection();
        $this->getTotalData();
        $this->getSubfamiliasLegacy();
        $this->createSubfamilias();
    }

    private function setUpLegacyConnection() {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalData() {
        $statement = "SELECT count(s.CLAVESUBFAM) AS count FROM subfamilias s LEFT JOIN subfamilias_categoria sc ON sc.subfamilia_clave = s.CLAVESUBFAM LEFT JOIN categorias g ON sc.categoria_clave = g.clave;";
        $this->totalData = $this->legacy->selectOne($statement)->count;
    }

    private function getSubfamiliasLegacy() {
        $statement = "SELECT s.CLAVESUBFAM AS clave, s.SUBFAMILIA AS nombre, s.famper AS clave_familia, g.categoria AS categoria FROM subfamilias s LEFT JOIN subfamilias_categoria sc ON sc.subfamilia_clave = s.CLAVESUBFAM LEFT JOIN categorias g ON sc.categoria_clave = g.clave;";
        $this->subfamiliasLegacy = $this->legacy->select($statement);
    }

    private function createSubfamilias() {
        $this->counter = 0;
        foreach ($this->subfamiliasLegacy as $subfamilia) {
            $familia = App\Familia::where('clave', $subfamilia->clave_familia)->first();
            if (is_null($familia)) {
                continue;
            }

            $margen = App\Margen::where('nombre', $subfamilia->categoria)->first();
            $margen_id = is_null($margen) ? null : $margen->id;

            $data = [
                'clave'      => $subfamilia->clave,
                'nombre'     => $subfamilia->nombre,
                'familia_id' => $familia->id,
                'margen_id'  => $margen_id
            ];
            DB::table('subfamilias')->insert($data);
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
        $this->command->getOutput()->write("\r<info>Seeding:</info> Subfamilia <comment>" . $progress . "</comment>");
    }

    private function printDebug($what, $params) {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln(sprintf("\n<question>%s</question> <info>%s</info>", $what, $param));
        }
    }
}
