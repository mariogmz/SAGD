<?php

use Illuminate\Database\Seeder;

class MetodoPagoRangoTableSeeder extends Seeder {

    /**
     * @var \Illuminate\Console\Command
     */
    protected $command;

    private $totalCount = 0;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->datos();
        echo "\n";
    }

    public function datos() {
        $current = 1;
        $errors = 0;
        // Crear conexión a la base de datos legacy
        $legacy = DB::connection('mysql_legacy');
        // Obtener los rangos desde la base de datos antigua, en el formato deseado para la nueva base de datos.
        $rangos = $legacy->select("select clave, truncate(rango0_10/100,2) as 0_10, truncate(rango10_15/100,2) as 11_15,
                                    truncate(rango15_20/100,2) as 16_20, truncate(rango20_25/100,2) as 21_25,
                                    truncate(rango25_30/100,2) as 26_30, truncate(rango30/100,2) as 31_100 from tipopago;");
        $this->totalCount = count($rangos) * 6;
        $lista_rangos = ['0_10', '11_15', '16_20', '21_25', '26_30', '31_100'];
        foreach ($rangos as $rango) {
            $rango = (array) $rango;
            $metodo_pago_id = App\MetodoPago::where('clave', $rango['clave'])->first()->id;
            foreach ($lista_rangos as $valor) {
                $desde_hasta = explode('_', $valor);
                $nuevo_rango = factory(App\MetodoPagoRango::class)->make([
                    'desde'          => $desde_hasta[0]/100,
                    'hasta'          => $desde_hasta[1]/100,
                    'valor'          => $rango[$valor],
                    'metodo_pago_id' => $metodo_pago_id
                ]);
                if (!$nuevo_rango->save()) {
                    $errors ++;
                    print_r($nuevo_rango);
                }
                $output = sprintf("%01.2f%%", ($current / $this->totalCount) * 100);
                $current ++;
                $this->command->getOutput()->write("\r<info>Seeding:</info> Metodo Pago Rango <comment>" . $output . "</comment>");
                if ($errors) {
                    $this->command->getOutput()->write("\t<error>Failed: " . $errors . " of " . $this->totalCount . "</error>");
                }
            }

        }
    }
}
