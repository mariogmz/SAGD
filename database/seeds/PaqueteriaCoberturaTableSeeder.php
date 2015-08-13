<?php

use Illuminate\Console\Command;
use Illuminate\Database\Seeder;

class PaqueteriaCoberturaTableSeeder extends Seeder
{

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
            $paqueteria = App\Paqueteria::where('clave', $paqueteria_cobertura->clave)->get()->first();
            $ocurre = is_null($paqueteria_cobertura->ocurre)? 0.0 : $paqueteria_cobertura->ocurre;
            for ($i=$paqueteria_cobertura->cp_desde; $i >= $paqueteria_cobertura->cp_hasta; $i++) {
                $codigo_postal = App\CodigoPostal::where('codigo_postal', $i)->get()->first();
                $paqueteria->coberturas()->attach($codigo_postal, ['ocurre' => $ocurre]);
                $this->printProgress(false);
            }
            $this->printProgress(true);
        }
    }

    private function printProgress($addCount)
    {
        $this->count += $addCount === true ? 1 : 0;
        $output = sprintf("%01.2f%%", ($this->count/$this->totalData)*100);
        $this->command->getOutput()->write("\r<info>Seeding:</info> PaqueteriaCobertura <comment>".$output."</comment>");
    }
}
