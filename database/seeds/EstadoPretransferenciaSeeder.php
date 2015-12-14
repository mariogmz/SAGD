<?php

use Illuminate\Database\Seeder;

class EstadoPretransferenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\EstadoPretransferencia::create(['nombre' => 'Sin Transferir']);
        App\EstadoPretransferencia::create(['nombre' => 'Transferido']);
    }
}
