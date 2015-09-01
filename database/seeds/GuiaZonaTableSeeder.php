<?php

use Illuminate\Database\Seeder;

class GuiaZonaTableSeeder extends Seeder {


    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $guias;
    protected $zonas;
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
        $this->getGuias();
        $this->getZonas();
        $this->createGuiasZonas();
    }

    private function setUpLegacyConnection() {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalData() {
        $statement = "SELECT count(p.clave) as count FROM paqueteria_costos pc JOIN paqueteria p ON pc.paqueteria_idpaqueteria = p.idpaqueteria;";
        $this->totalData = $this->legacy->select($statement)[0]->count;
        $this->totalData *= count(App\Zona::all());
    }

    private function getGuias() {
        $statement = "SELECT p.clave as clave, pc.costo1 as costo1, pc.sobrepeso1 as costo_sobrepeso1,  pc.costo2 as costo2, pc.sobrepeso2 as costo_sobrepeso2,  pc.costo3 as costo3, pc.sobrepeso3 as costo_sobrepeso3,  pc.costo4 as costo4, pc.sobrepeso4 as costo_sobrepeso4,  pc.costo5 as costo5, pc.sobrepeso5 as costo_sobrepeso5,  pc.costo6 as costo6, pc.sobrepeso6 as costo_sobrepeso6,  pc.costo7 as costo7, pc.sobrepeso7 as costo_sobrepeso7 FROM paqueteria_costos pc JOIN paqueteria p ON pc.paqueteria_idpaqueteria = p.idpaqueteria;";
        $this->guias = $this->legacy->select($statement);
    }

    private function getZonas() {
        $this->zonas = App\Zona::all();
    }

    private function createGuiasZonas() {
        $this->counter = 1;
        foreach ($this->guias as $guia) {
            $appguia = $this->getRealGuia($guia);

            foreach ($this->zonas as $zona) {
                $command = sprintf("\$data = ['costo' => \$guia->costo%d, 'costo_sobrepeso' => \$guia->costo_sobrepeso%d];", $zona->id, $zona->id);
                eval("$command;");

                $data = array_merge($data, ['guia_id' => $appguia->id]);
                $data = array_merge($data, ['zona_id' => $zona->id]);

                DB::table('guias_zonas')->insert($data);
                $this->counter ++;
                $this->printProgress();
            }
        }
        echo "\n";
    }

    private function getRealGuia($guia) {
        $appguias = App\Guia::all();
        foreach ($appguias as $ag) {
            if ($ag->paqueteria->clave === $guia->clave) {
                return $ag;
            }
        }
    }

    private function printProgress() {
        $progress = sprintf("%01.2f%%", ($this->counter / $this->totalData) * 100);
        if ($progress <= 0.01) {
            $progress = 0.01;
        }
        $this->command->getOutput()->write("\r<info>Seeding:</info> GuiaZona <comment>" . $progress . "</comment>");
    }

    private function printDebug($what, $params) {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln(sprintf("\n<question>%s</question> <info>%s</info>", $what, $param));
        }
    }
}
