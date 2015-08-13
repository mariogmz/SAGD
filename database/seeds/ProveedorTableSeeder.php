<?php

use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->internos();
        $this->externos();
    }

    public function internos() {
        factory(App\Proveedor::class)->create([
            'clave'        => 'DICO',
            'razon_social' => 'DICOTECH MAYORISTA DE TECNOLOGIA S.A. DE C.V.',
            'externo'      => 0,
            'pagina_web'   => 'http://www.dicotech.com.mx'
        ]);
    }

    public function externos() {
        // Crear conexión a la base de datos legacy
        $legacy = DB::connection('mysql_legacy');
        // Obtener los proveedores desde la base de datos antigüa, en el formato deseado para la nueva base de datos.
        $proveedores = $legacy->select("select upper(substr(clave,1,6)) as clave, Razonsocial as razon_social, 1 as externo, if(Pagina='NULL' OR Pagina like 'X%' OR Pagina = '1',null,Pagina) as pagina_web from proveedor;");
        foreach ($proveedores as $proveedor) {
            $nuevo_proveedor = factory(App\Proveedor::class)->make((array) $proveedor);
            if (substr($nuevo_proveedor->pagina_web, 1, 7) != 'http://') {
                $nuevo_proveedor->pagina_web = 'http://' . $nuevo_proveedor->pagina_web;
            }
            if (!$nuevo_proveedor->save()) {
                echo "Error, no se pudo insertar el proveedor en la base de datos: \n";
                print_r([$proveedor->clave, $nuevo_proveedor->errors->toArray()]);
                echo "\n";
            }
        }
    }
}
