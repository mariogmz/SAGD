<?php

use Illuminate\Database\Seeder;

class MetodoPagoTableSeeder extends Seeder {

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
        // Obtener los proveedores desde la base de datos antigua, en el formato deseado para la nueva base de datos.
        $tipos_pagos = $legacy->select("SELECT clave,descripcion as 'nombre',truncate(comision/100,5) as 'comision',montominimo as 'monto_minimo',null as 'informacion_adicional', if(activo=1,4,1) estatus_activo_id FROM sazpruebas.tipopago;");
        $this->totalCount = count($tipos_pagos);
        foreach ($tipos_pagos as $tipo_pago) {
            $nuevo_tipo = factory(App\MetodoPago::class)->make((array) $tipo_pago);
            if (!$nuevo_tipo->save()) {
                $errors ++;
            }
            $output = sprintf("%01.2f%%", ($current / $this->totalCount) * 100);
            $current ++;
            $this->command->getOutput()->write("\r<info>Seeding:</info> Metodo Pago <comment>" . $output . "</comment>");
            if ($errors) {
                $this->command->getOutput()->write("\t<error>Failed: " . $errors . " of " . $this->totalCount . "</error>");
            }
        }
    }
}
