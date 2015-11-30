<?php

use Illuminate\Database\Seeder;

class SucursalTableSeeder extends Seeder {

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
        $sucursales = $this->prepararDatos();
        $current = 1;
        $errors = 0;
        $this->totalCount = count($sucursales);
        foreach ($sucursales as $sucursal) {
            if (!$sucursal->save()) {
                $errors ++;
            }
            $output = sprintf("%01.2f%%", ($current / $this->totalCount) * 100);
            $current ++;
            $this->command->getOutput()->write("\r<info>Seeding:</info> Sucursal <comment>" . $output . "</comment>");
            if ($errors) {
                $this->command->getOutput()->write("\t<error>Failed: " . $errors . " of " . $this->totalCount . "</error>");
            }
        }
        echo "\n";
    }

    private function prepararDatos() {
        $proveedores = [
            'dicotech' => App\Proveedor::where('clave', 'DICO')->lists('id')->first(),
            'ingram'   => App\Proveedor::where('clave', 'INGRAM')->lists('id')->first()
        ];
        $sucursales = [];
        // Dicotech Aguascalientes
        array_push($sucursales, new App\Sucursal([
            'clave'        => 'DICOTAGS',
            'nombre'       => 'Dicotech Aguascalientes',
            'horarios'     => 'Lunes a Viernes de 9:00am a 6:30pm, Sábados de 9:00am a 2:30pm',
            'proveedor_id' => $proveedores['dicotech'],
            'domicilio_id' => factory(App\Domicilio::class)->create([
                'calle'            => 'Av. de la Convención de 1914 Norte #502, Col. Morelos',
                'localidad'        => 'Aguascalientes',
                'codigo_postal_id' => App\CodigoPostal::where('codigo_postal', '20140')->lists('id')->first(),
            ])->id,
            'ubicacion'    => null
        ]));
        // Dicotech León
        array_push($sucursales, new App\Sucursal([
            'clave'        => 'DICOLEON',
            'nombre'       => 'Dicotech León',
            'horarios'     => 'Lunes a Viernes de 9:00am a 7:00pm, Sábados de 9:00am a 3:00pm',
            'proveedor_id' => $proveedores['dicotech'],
            'domicilio_id' => factory(App\Domicilio::class)->create([
                'calle'            => 'Blvd. Hilario Medina #4006 Col. Real Providencia',
                'localidad'        => 'León',
                'codigo_postal_id' => App\CodigoPostal::where('codigo_postal', '37234')->lists('id')->first(),
            ])->id,
            'ubicacion'    => null
        ]));
        // Zegucom Zacatecas
        array_push($sucursales, new App\Sucursal([
            'clave'        => 'ZEGUCZAC',
            'nombre'       => 'Zegucom Zacatecas',
            'horarios'     => 'Lunes a Viernes de 9:00am a 7:00pm, Sábados de 9:00am a 3:00pm',
            'proveedor_id' => $proveedores['dicotech'],
            'domicilio_id' => factory(App\Domicilio::class)->create([
                'calle'            => 'Av. Revolución Mexicana #32, San Miguel Del Cortijo',
                'localidad'        => 'Guadalupe',
                'codigo_postal_id' => App\CodigoPostal::where('codigo_postal', '98615')->lists('id')->first(),
            ])->id,
            'ubicacion'    => null
        ]));
        // Zegucom Arboledas
        array_push($sucursales, new App\Sucursal([
            'clave'        => 'ZEGUCARB',
            'nombre'       => 'Zegucom Arboledas',
            'horarios'     => 'Lunes a Viernes de 9:00am a 7:00pm, Sábados de 9:00am a 3:00pm',
            'proveedor_id' => $proveedores['dicotech'],
            'domicilio_id' => factory(App\Domicilio::class)->create([
                'calle'            => 'Av. Convención de 1914 norte #1405, Fracc. Las Arboledas',
                'localidad'        => 'Aguascalientes',
                'codigo_postal_id' => App\CodigoPostal::where('codigo_postal', '20020')->lists('id')->first(),
            ])->id,
            'ubicacion'    => null
        ]));
        // Ingram León
        array_push($sucursales, new App\Sucursal([
            'clave'        => 'INGRLEON',
            'nombre'       => 'INGRAM León',
            'horarios'     => 'Lunes a Viernes de 9:00am a 2:00pm, 4:00pm a 7:00pm',
            'proveedor_id' => $proveedores['ingram'],
            'domicilio_id' => factory(App\Domicilio::class)->create([
                'calle'            => 'Blvd José Ma. Morelos #2812, Col. Prado Hermoso.',
                'localidad'        => 'León',
                'codigo_postal_id' => App\CodigoPostal::where('codigo_postal', '37238')->lists('id')->first(),
            ])->id,
            'ubicacion'    => null
        ]));
        // Ingram DF
        array_push($sucursales, new App\Sucursal([
            'clave'        => 'INGRAMDF',
            'nombre'       => 'INGRAM D.F.',
            'horarios'     => 'Lunes a Viernes de 9:00am a 2:00pm, 4:00pm a 7:00pm',
            'proveedor_id' => $proveedores['ingram'],
            'domicilio_id' => factory(App\Domicilio::class)->create([
                'calle'            => 'Av. 16 de Septiembre #225, Col. Barrio de San Martin.',
                'localidad'        => 'Aguascalientes',
                'codigo_postal_id' => App\CodigoPostal::where('codigo_postal', '02140')->lists('id')->first(),
            ])->id,
            'ubicacion'    => null
        ]));

        return $sucursales;
    }
}
