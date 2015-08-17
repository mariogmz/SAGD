<?php

use Illuminate\Database\Seeder;

class GuiaTableSeeder extends Seeder
{

     /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    protected $legacy;
    protected $totalData;
    protected $data;
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
        $this->getTotalCountOfData();
        $this->getGuias();
        $this->addGuias();

    }

    private function setUpLegacyConnection()
    {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getTotalCountOfData()
    {
        $statement = "SELECT count(p.clave) as count FROM paqueteria_costos pc INNER JOIN paqueteria p ON pc.paqueteria_idpaqueteria = p.idpaqueteria;";
        $this->totalData = $this->legacy->select($statement)[0]->count;
    }

    private function getGuias()
    {
        $statement = "SELECT p.clave as clave, pc.nombre_adicional as nombre, pc.vol_cubico_max as volumen_maximo, pc.ampara_hasta as ampara_hasta, pc.activa_interno as interno, pc.activa_web as web FROM paqueteria_costos pc JOIN paqueteria p ON pc.paqueteria_idpaqueteria = p.idpaqueteria;";
        $this->data = $this->legacy->select($statement);
    }

    private function addGuias()
    {
        foreach ($this->data as $data) {
            $paqueteria = App\Paqueteria::where('clave', $data->clave)->first();
            if(is_null($paqueteria)){continue;}

            $estado = $this->getEstadoActivo($data->interno, $data->web);

            unset($data->clave);
            unset($data->interno);
            unset($data->web);
            $data = (array)$data;
            $data = array_merge($data, ["paqueteria_id" => $paqueteria->id]);
            $data = array_merge($data, ["estatus_activo_id" => $estado->id]);

            DB::table('guias')->insert($data);
            $this->count++;
            $this->printProgress();
        }
        echo "\n";
    }

    private function getEstadoActivo($sistema, $pagina)
    {
        switch($sistema + $pagina){
            case 0:
                return App\EstatusActivo::where('estatus', 'NINGUNO')->first();
                break;
            case 1:
                if($sistema){
                    return App\EstatusActivo::where('estatus', 'SISTEMA')->first();
                } else {
                    return App\EstatusActivo::where('estatus', 'PAGINA')->first();
                }
                break;
            case 2:
                return App\EstatusActivo::where('estatus', 'AMBOS')->first();
                break;
        }
    }

    private function printProgress()
    {
        $progress = sprintf("%01.2f%%", ($this->count/$this->totalData)*100);
        if($progress <= 0.01){$progress = 0.01;}
        $this->command->getOutput()->write("\r<info>Seeding:</info> Guia <comment>".$progress."</comment>");
    }

    private function printDebug($what, $params)
    {
        foreach ($params as $param) {
            $this->command->getOutput()->writeln( sprintf("\n<question>%s</question> <info>%s</info>", $what, $param) );
        }
    }
}
