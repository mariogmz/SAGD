<?php

use Illuminate\Database\Seeder;

class RmaTiempoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tiempos = ['Menor a dos meses', 'Mayor a dos meses'];
        foreach ($tiempos as $tiempo) {
            App\RmaTiempo::create(['nombre' => $tiempo]);
        }
    }
}
