<?php

use Illuminate\Database\Seeder;

class EstatusActivoTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $estatus = ['NINGUNO', 'SISTEMA', 'PAGINA', 'AMBOS'];
        foreach ($estatus as $st) {
            App\EstatusActivo::create([
                'estatus' => $st
            ]);
        }
    }
}
