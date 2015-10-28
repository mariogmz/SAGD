<?php

use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Seeder;

use App\DatoContacto;
use App\Empleado;
use App\Sucursal;
use Carbon\Carbon;

class EmpleadoTableSeeder extends Seeder
{

    protected $legacy;
    protected $empleadosLegacy;
    protected $progressBar;
    protected $noEmailErrorCount;

    private  $SUCURSALES = [
        'DICOTECH'  => 'DICOTAGS',
        'ZACATECAS' => 'ZEGUCZAC',
        'ARBOLEDAS' => 'ZEGUCARB',
        'LEON'      => 'DICOLEON'
    ];
    private  $USER_BLACKLIST = [
        'leury',
        'pepito',
        'test',
        'internet'
    ];

    public function __construct()
    {
        $this->noEmailErrorCount = 0;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUpLegacyConncetion();
        $this->getEmpleadosLegacy();
        $this->createNewEmpleados();
     }

    private function setUpLegacyConncetion()
    {
        $this->legacy = DB::connection('mysql_legacy');
    }

    private function getEmpleadosLegacy()
    {
        $statement = "SELECT e.nombre, lower(e.usuario) as usuario, e.activo,
        e.direccion, e.telefono, e.email, e.skype, upper(s.clave) as sucursal
        FROM empleado e INNER JOIN sucursales s ON s.numero = e.sucursal_numero;";

        $this->empleadosLegacy = $this->legacy->select($statement);
    }

    private function createNewEmpleados()
    {
        $this->progressBar = new ProgressBar($this->command->getOutput(), count($this->empleadosLegacy) + 1);
        $this->progressBar->setFormat("<info>Seeding:</info> Empleados : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progressBar->start();

        $this->createAdmin();
        $this->progressBar->advance();
        foreach ($this->empleadosLegacy as $empleadoLegacy) {
            if ($this->isInBlackList($empleadoLegacy)) {
                $this->progressBar->advance();
                continue;
            }
            $this->migrate($empleadoLegacy);
            $this->progressBar->advance();
        }
        $this->progressBar->finish();
        $this->command->getOutput()->writeln("");

        $this->printErrors();
    }

    /**
     * Ejecuta el codigo para migrar de empleadoLegacy a Empleado
     * @param stdClass $empleadoLegacy
     * @return void
     */
    private function migrate($empleadoLegacy)
    {
        $sucursal = Sucursal::whereClave( $this->SUCURSALES[$empleadoLegacy->sucursal] )->first();
        $datoContacto = new DatoContacto([
            'direccion'         => $empleadoLegacy->direccion,
            'telefono'          => $empleadoLegacy->telefono,
            'email'             => $empleadoLegacy->email,
            'skype'             => $empleadoLegacy->skype,
            'fotografia_url'    => "",
        ]);
        $empleado = new Empleado([
            'nombre' => $this->normalize($empleadoLegacy->nombre),
            'usuario' => $empleadoLegacy->usuario,
            'activo' => $empleadoLegacy->activo,
            'puesto' => '',
            'fecha_cambio_password' => Carbon::now('America/Mexico_City')
        ]);

        $sucursal->empleados()->save($empleado);
        $empleado->datoContacto()->save($datoContacto);

        if ($datoContacto->email) {
            $this->noEmailErrorCount++;
        }
    }

    /**
     * Imprime los errores encontrados en el seed
     * @return void
     */
    private function printErrors()
    {
        if ($this->noEmailErrorCount > 0) {
            $messages = [];
            array_push($messages, "<error>Se encontraron ". $this->noEmailErrorCount ." registros sin e-mail</error>");
            array_push($messages, "Sin un e-mail no se puede crear un User para que puedan iniciar sesión");
            array_push($messages, "Favor de revisar en caso de que estos empleados requieran acceso al SAGD");
            $this->command->getOutput()->writeln($messages);
        }
    }

    /**
     * Crea el Empleado/Admin para sistemas@zegucom.com.mx
     * Con password: admin2015
     * @return void
     */
    private function createAdmin()
    {
        $sucursal = App\Sucursal::where('clave', 'DICOTAGS')->first();

        $empleados = [
            [
                'empleado' => [
                    'nombre' => 'Administrador',
                    'usuario' => 'admin',
                    'activo' => 1,
                    'puesto' => 'Administrador',
                    'fecha_cambio_password' => Carbon::now('America/Mexico_City')
                ],
                'dato_contacto' => [
                    'email' => 'sistemas@zegucom.com.mx'
                ]
            ]
        ];

        foreach ($empleados as $empleado) {
            $e = new Empleado($empleado['empleado']);
            $dc = new DatoContacto($empleado['dato_contacto']);

            $sucursal->empleados()->save($e);
            $e->datoContacto()->save($dc);
        }
    }

    /**
     * Revisa si el empleado se va o no a importar
     * @param stdClass $empleado
     * @return void
     */
    private function isInBlackList($empleado)
    {
        return in_array($empleado->usuario, $this->USER_BLACKLIST);
    }

    /**
     * Normaliza una cadena al formato de `capitalize` de Ruby
     *
     * @param string $string
     * @return string
     */
    private function normalize($string)
    {
        return ucfirst(strtolower($string));
    }
}
