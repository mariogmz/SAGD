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
    protected $offset;

    protected $startTime;
    protected $optIter = 0;
    protected $optDesde = 0;
    protected $optHasta = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->setUpLegacyConnection();
        $this->getTotalCountOfData();
        $this->parsePaqueteriasCoberturas();
    }

    private function setUpLegacyConnection()
    {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalCountOfData()
    {
        $statement = "SELECT count(id) as count FROM paqueteria_cobertura;";
        $this->totalData = $this->legacy->select($statement)[0]->count;
    }

    private function getPaqueteriasCoberturas($offset)
    {
        $statement = "SELECT p.clave as clave, pc.cp_desde, pc.cp_hasta, pc.ocurre FROM paqueteria_cobertura pc INNER JOIN paqueteria p ON pc.idpaqueteria = p.idpaqueteria LIMIT 1000 OFFSET ".$offset.";";
        $this->data = $this->legacy->select($statement);
        return $this->data;
    }

    private function parsePaqueteriasCoberturas()
    {
        $this->count = 1;
        $this->offset = 0;
        $this->startTime = microtime(true);

        while ( $this->getPaqueteriasCoberturas($this->offset) ){
            foreach ($this->data as $paqueteria_cobertura) {
                $paqueteria = App\Paqueteria::where('clave', $paqueteria_cobertura->clave)->first();
                if(is_null($paqueteria)){continue;}

                $ocurre = is_null($paqueteria_cobertura->ocurre)? 0.0 : $paqueteria_cobertura->ocurre;

                for ($i=$paqueteria_cobertura->cp_desde; $i <= $paqueteria_cobertura->cp_hasta; $i++) {
                    if($i>100000){break;}
                    $codigo_postal = App\CodigoPostal::where('codigo_postal', $i)->first();
                    if(is_null($codigo_postal)){continue;}

                    $pc = App\PaqueteriaCobertura::where('paqueteria_id', $paqueteria->id)->where('codigo_postal_id', $codigo_postal->id)->first();
                    if( is_null($pc) ){
                        $paqueteria->coberturas()->attach($codigo_postal, ['ocurre' => $ocurre]);
                        $this->optIter = $i;
                        $this->optDesde = $paqueteria_cobertura->cp_desde;
                        $this->optHasta = $paqueteria_cobertura->cp_hasta;
                    }
                    $this->printProgress(false);
                }
                $this->printProgress(true);
            }
            $this->offset += 1000;
        }

        echo "\n";
    }

    private function printProgress($addCount)
    {
        $this->count += $addCount === true ? 1 : 0;
        $progress = sprintf("%01.2f%%", ($this->count/$this->totalData)*100);
        if($progress <= 0.01){$progress = 0.01;}
        $elapsedTime = sprintf("%5d", $this->getElapsedTime());
        $eta = (($elapsedTime*100.0)/$progress)-$elapsedTime;
        if ($eta > 60.0)
        {
            $minutes = (int)$eta/60;
            $seconds = $eta - ($minutes*60);
            $eta = sprintf("%2dm %2ds", $minutes, $seconds);
        }

        $this->command->getOutput()->write(
            "\r<info>Seeding:</info> PaqueteriaCobertura <comment>".$progress
            ."</comment> <question>Elapsed:</question> ".$elapsedTime.
            "s <question>ETA:</question> ".$eta.
            " <question>CP1:</question> ". $this->optDesde.
            " <question>CP2:</question> ". $this->optHasta.
            " <question>ITE:</question> ". $this->optIter.
            " <question>OFF:</question> ". $this->offset
        );
    }

    private function printDebug($what, $params)
    {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln( sprintf("\n<question>%s: </question><info>%s</info>", $what, $param) );
        }
    }

    /**
     * Get the elapsed time since a given starting point.
     *
     * @param  int    $start
     * @return float
     */
    private function getElapsedTime()
    {
        return round((microtime(true) - $this->startTime), 2);
    }
}
