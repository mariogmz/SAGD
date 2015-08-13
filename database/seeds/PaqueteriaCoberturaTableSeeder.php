<?php

use Illuminate\Console\Command;
use Illuminate\Database\Seeder;

class PaqueteriaCoberturaTableSeeder extends Seeder
{

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $data;
    protected $totalData;
    protected $count;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->setUpLegacyConnection();
        $this->getPaqueteriasCoberturas();
        $this->parsePaqueteriasCoberturas();
    }

    private function setUpLegacyConnection()
    {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getPaqueteriasCoberturas()
    {
        $statement = "SELECT p.clave as clave, pc.cp_desde, pc.cp_hasta, pc.ocurre FROM paqueteria_cobertura pc INNER JOIN paqueteria p ON pc.idpaqueteria = p.idpaqueteria;";
        $this->data = $this->legacy->select($statement);
        $this->totalData = count($this->data);
    }

    private function parsePaqueteriasCoberturas()
    {
        $this->count = 1;
        foreach ($this->data as $paqueteria_cobertura) {
            $paqueteria = App\Paqueteria::where('clave', $paqueteria_cobertura->clave)->first();
            if(is_null($paqueteria))
            {
                $this->printDebug("Paqueteria", (string)$paqueteria);
                $this->printDebug("Clave", $paqueteria_cobertura->clave);
                continue;
            }
            $ocurre = is_null($paqueteria_cobertura->ocurre)? 0.0 : $paqueteria_cobertura->ocurre;

            if ($paqueteria_cobertura->cp_desde === $paqueteria_cobertura->cp_hasta)
            {
                $codigo_postal = App\CodigoPostal::where('codigo_postal', $paqueteria_cobertura->cp_desde)->get()->first();
                $paqueteria->coberturas()->attach($codigo_postal, ['ocurre' => $ocurre]);
                $this->printProgress(false);
            } else {
                for ($i=$paqueteria_cobertura->cp_desde; $i > $paqueteria_cobertura->cp_hasta; $i++) {
                    $codigo_postal = App\CodigoPostal::where('codigo_postal', $i)->get()->first();

                    $this->printDebug("CP Desde", $paqueteria_cobertura->cp_desde);
                    $this->printDebug("CP Hasta", $paqueteria_cobertura->cp_hasta);
                    $this->printDebug("Iteracion", (string)$i);
                    $this->printDebug("Paqueteria", $paqueteria->clave);
                    $this->printDebug("CP", $codigo_postal->estado);
                    $this->printDebug("Count", (string)$this->count);

                    $paqueteria->coberturas()->attach($codigo_postal, ['ocurre' => $ocurre]);
                    $this->printProgress(false);
                }
            }
            $this->printProgress(true);
        }
        echo "\n";
    }

    private function printProgress($addCount)
    {
        $this->count += $addCount === true ? 1 : 0;
        $output = sprintf("%01.2f%%", ($this->count/$this->totalData)*100);
        $this->command->getOutput()->write("\r<info>Seeding:</info> PaqueteriaCobertura <comment>".$output."</comment>");
    }

    private function printDebug($what, $param)
    {
        $this->command->getOutput()->writeln( sprintf("\n<question>%s: </question><info>%s</info>", $what, $param) );
    }
}
