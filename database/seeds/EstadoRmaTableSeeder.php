<?php

use Illuminate\Database\Seeder;

class EstadoRmaTableSeeder extends Seeder {

    private $totalCount = 0;
    private $errors = 0;
    private $current = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $estados_soporte = [
            'RMA cancelado',
            'Producto o equipo recibido.',
            'Revisando.',
            'Cambio autorizado.',
            'Nota de crédito generada a favor del cliente.',
            'Pieza o producto enviado para cambio a proveedor.',
            'Pieza o producto cambiado por proveedor en espera de regreso a cliente.',
            'RMA finalizado producto regresado a cliente.',
        ];
        $this->totalCount = count($estados_soporte);
        foreach ($estados_soporte as $estado) {
            $estado_rma = factory(App\EstadoRma::class)->make(['nombre' => $estado]);
            if (!$estado_rma->save()) {
                $this->errors ++;
            };
            $output = sprintf("%01.2f%%", ($this->current / $this->totalCount) * 100);
            $this->current ++;
            $this->command->getOutput()->write("\r<info>Seeding:</info> Estado Rma <comment>" . $output . "</comment>");
            if ($this->errors) {
                $this->command->getOutput()->write("\t<error>Failed: " . $this->errors . " of " . $this->totalCount . "</error>");
            }
        }
        echo "\n";
    }
}
