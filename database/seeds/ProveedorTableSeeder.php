<?php

use Illuminate\Database\Seeder;

class ProveedorTableSeeder extends Seeder {

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
        $this->internos();
        $this->externos();
        echo "\n";
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
        $current = 1;
        $errors = 0;
        // Crear conexión a la base de datos legacy
        $legacy = DB::connection('mysql_legacy');
        // Obtener los proveedores desde la base de datos antigüa, en el formato deseado para la nueva base de datos.
        $proveedores = $legacy->select("select upper(substr(clave,1,6)) as clave, Razonsocial as razon_social, 1 as externo, if(Pagina='NULL' OR Pagina like 'X%' OR Pagina = '1',null,Pagina) as pagina_web from proveedor;");
        $this->totalCount = count($proveedores);
        foreach ($proveedores as $proveedor) {
            $nuevo_proveedor = factory(App\Proveedor::class)->make((array) $proveedor);
            if (substr($proveedor->pagina_web, 0, 7) !== 'http://' || substr($proveedor->pagina_web, 0, 8) !== 'https://') {
                $nuevo_proveedor->pagina_web = 'http://' . $nuevo_proveedor->pagina_web;
            }
            if (!$nuevo_proveedor->save()) {
                $errors ++;
            }
            $output = sprintf("%01.2f%%", ($current / $this->totalCount) * 100);
            $current ++;
            $this->command->getOutput()->write("\r<info>Seeding:</info> Proveedor <comment>" . $output . "</comment>");
            if ($errors) {
                $this->command->getOutput()->write("\t<error>Failed: " . $errors . " of " . $this->totalCount . "</error>");
            }
        }
    }
}
