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
        // Obtener los proveedores desde la base de datos antigua, en el formato deseado para la nueva base de datos.
        $proveedores = $legacy->select("select upper(substr(clave,1,7)) as clave, Razonsocial as razon_social, 1 as externo, if(Pagina='NULL' OR Pagina like 'X%' OR Pagina like 'C%' OR Pagina = '1',null,LOWER(Pagina)) as pagina_web from proveedor;");
        $this->totalCount = count($proveedores);
        foreach ($proveedores as $proveedor) {
            $nuevo_proveedor = new App\Proveedor((array) $proveedor);
            if (empty($nuevo_proveedor->pagina_web)) {
                $nuevo_proveedor->pagina_web = '';
            } else {
                $protocol = [];
                $tld = [];
                preg_match('/^http(s):\/\//', $nuevo_proveedor->pagina_web, $protocol);
                preg_match('/\.(com|org|net|biz|co|mx)(\.mx.?)?$/', $nuevo_proveedor->pagina_web, $tld);

                if (empty($protocol)) {
                    $nuevo_proveedor->pagina_web = 'http://' . $nuevo_proveedor->pagina_web;
                }

                if (empty($tld)) {
                    $nuevo_proveedor->pagina_web .= '.com';
                }
            }
            if (!$nuevo_proveedor->save()) {
                $nuevo_proveedor->clave .= '1';
                if (!$nuevo_proveedor->save()) {
                    $errors ++;
                }
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
