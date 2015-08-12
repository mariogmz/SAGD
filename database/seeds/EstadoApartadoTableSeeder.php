<?php

use Illuminate\Database\Seeder;

class EstadoApartadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\EstadoApartado::class)->create(['nombre' => 'Sin Apartar']);
        factory(App\EstadoApartado::class)->create(['nombre' => 'Apartado']);
        factory(App\EstadoApartado::class)->create(['nombre' => 'Desapartado']);
    }
}
