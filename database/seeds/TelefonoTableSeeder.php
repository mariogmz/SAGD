<?php

use Illuminate\Database\Seeder;

class TelefonoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->crearTelefonos();
    }

    public function crearTelefonos() {
        // Dicotech Ags
        App\Sucursal::where('clave', 'DICOTAGS')->first()->domicilio->telefonos()->create([
            'numero' => '4499967409',
            'tipo'   => 'Trabajo'
        ]);
        // Dicotech León
        App\Sucursal::where('clave', 'DICOLEON')->first()->domicilio->telefonos()->createMany([
            [
                'numero' => '4777175152',
                'tipo'   => 'Trabajo'
            ],[
                'numero' => '4773901127',
                'tipo'   => 'Trabajo'
            ]
        ]);
        // Zegucom Zacatecas
        App\Sucursal::where('clave', 'ZEGUCZAC')->first()->domicilio->telefonos()->create([
            'numero' => '4499253331',
            'tipo'   => 'Trabajo'
        ]);
        // Zegucom Arboledas
        App\Sucursal::where('clave', 'ZEGUCARB')->first()->domicilio->telefonos()->create([
            'numero' => '4491468780',
            'tipo'   => 'Trabajo'
        ]);
        // Ingram León
        App\Sucursal::where('clave', 'INGRLEON')->first()->domicilio->telefonos()->create([
            'numero' => '4777886000',
            'tipo'   => 'Trabajo'
        ]);
        // Ingram D.F.
        App\Sucursal::where('clave', 'INGRAMDF')->first()->domicilio->telefonos()->create([
            'numero' => '5552636500',
            'tipo'   => 'Trabajo'
        ]);
    }
}
