<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

class ClienteTableSeeder extends Seeder {

    private $legacy;

    private $clientes;
    private $usuarios;
    private $comentarios;
    private $domicilios;
    private $telefonos;

    protected $progress_bar;
    protected $errors;
    protected $success;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->setUp();
        try {
            DB::beginTransaction();
            $this->obtenerDatos();
            $this->seedClientes();
            $this->seedUsuarios();
            $this->seedComentarios();
            $this->seedDomicilios();
            $this->seedTelefonos();
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            $this->command->getOutput()->writeln("");
            $this->command->getOutput()->writeln("<error>{$ex->getMessage()}</error>");
            $this->command->getOutput()->writeln("<error>{$ex->getFile()}</error>");
            $this->command->getOutput()->writeln("<error>{$ex->getLine()}</error>");
            Log::error('Error on ClienteTableSeeder', [
                'stackTrace' => $ex->getTraceAsString()
            ]);
        }
    }

    private function setUp() {
        $this->legacy = DB::connection('mysql_legacy');
        $this->clientes = [];
        $this->usuarios = [];
        $this->comentarios = [];
        $this->domicilios = [];
        $this->telefonos = [];

        $this->success = 0;
        $this->errors = 0;

    }

    private function obtenerDatos() {
        // Clientes
        $this->clientes = $this->legacy->select("
        SELECT
          clave,
          IF(usuario IS NULL OR usuario = '',clave,usuario) AS usuario,
          nombre,
          NULL AS fecha_nacimiento,
          'HOMBRE' AS sexo,
          IF(ocupacion = 'NULL' OR ocupacion = '',NULL,ocupacion) AS ocupacion,
          IF(YEAR(fechaverificocorreo) > 0,  DATE_FORMAT(fechaverificocorreo, '%Y-%m-%d %H:%i:%s'), NULL) AS fecha_verificacion_correo,
          IF(club_zegucom = 0, NULL, DATE_FORMAT(club_expira, '%Y-%m-%d %H:%i:%s')) AS fecha_expira_club_zegucom,
          IF(seentero = 0, NULL, seentero) AS referencia_otro,
          IF(activo = 1, 2, 3) AS cliente_estatus_id,
          8 AS rol_id, -- Rol de usuario final (8)
          CASE sucursal_clave
            WHEN 'dicotech' THEN 1
            WHEN 'leon' THEN 2
            WHEN 'Zacatecas' THEN 3
            WHEN 'Arboledas' THEN 4
            WHEN 'imleon' THEN 2
            WHEN 'imdf' THEN 1
            ELSE 4
          END AS sucursal_id
        FROM clientes;");

        // Usuarios
        $this->usuarios = $this->legacy->select("
        SELECT
          clave,
          IF(usuario IS NULL OR usuario = '',clave,usuario) AS usuario,
          REPLACE(email,' ','') as email,
          password
        FROM clientes
        WHERE
          email IS NOT NULL
          AND email <> '';");

        // Comentarios
        $this->comentarios = $this->legacy->select("
        SELECT
          IF(usuario IS NULL OR usuario = '',clave,usuario) AS usuario,
          comentario,
          1 AS empleado_id,
          fecha AS updated_at
        FROM cliente_comentario
        JOIN clientes ON clientes.clave = cliente_comentario.cliente_clave;");

        // Domicilios
        $this->domicilios = $this->legacy->select("
        SELECT
         IF(usuario IS NULL OR usuario = '',clave,usuario) AS usuario,
          IF(domicilio = '' OR domicilio IS NULL,lugar,domicilio) AS calle,
          lugar AS localidad,
          TRIM(cp) AS codigo_postal
        FROM clientes
        WHERE
          cp <> 0 AND cp <> 'NULL'
          AND lugar <> '' AND lugar <> 'NULL';");

        // Teléfonos
        $this->telefonos = $this->legacy->select("
        SELECT
          IF(usuario IS NULL OR usuario = '',clave,usuario) AS usuario,
          telefono AS numero,
          'FIJO' AS tipo
        FROM clientes
        WHERE
          telefono IS NOT NULL
          AND telefono <> ''
          AND telefono <> 'NULL'
        UNION
        SELECT
          IF(usuario IS NULL OR usuario = '',clave,usuario) AS usuario,
          celular AS numero,
          'CELULAR' AS tipo
        FROM clientes
        WHERE
          telefono IS NOT NULL
          AND telefono <> ''
          AND telefono <> 'NULL';");
    }

    private function seedClientes() {
        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($this->clientes) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();
        foreach ($this->clientes as $cliente) {
            $nuevo_cliente = new App\Cliente();
            // Workaround when the name is empty (which shouldn't)
            if (empty($cliente->nombre)) {
                $cliente->nombre = $cliente->usuario;
            }
            // Workaround when the username was already taken
            if (!empty(App\Cliente::where('usuario',$cliente->usuario)->get())) {
                $cliente->usuario = $cliente->clave;
            }
            $nuevo_cliente->fill((array) $cliente);
            if (!$nuevo_cliente->save()) {
                $this->errors ++;
                $this->logErrors($nuevo_cliente);
            } else {
                $this->success ++;
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults();
    }

    private function seedUsuarios() {
        $this->errors = 0;
        $this->success = 0;
        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($this->usuarios) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Usuarios-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        foreach ($this->usuarios as $usuario) {
            if (!empty($cliente = App\Cliente::where('usuario',$usuario->usuario)->orWhere('usuario', $usuario->clave)->first())) {
                $nuevo_usuario = new App\User();
                $nuevo_usuario->email = $usuario->email;
                $nuevo_usuario->password = \Hash::make($usuario->password);
                $nuevo_usuario->morphable_id = $cliente->id;
                $nuevo_usuario->morphable_type = 'App\Cliente';
                if (!$nuevo_usuario->save()) {
                    $this->errors ++;
                    $this->logErrors($nuevo_usuario);
                } else {
                    $this->success ++;
                }
            }

            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults();
    }

    private function seedComentarios() {
        $this->errors = 0;
        $this->success = 0;
        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($this->comentarios) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Comentarios-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        foreach ($this->comentarios as $comentario) {
            if (!empty($cliente = App\Cliente::where('usuario',$comentario->usuario))) {
                $cliente_comentario = new App\ClienteComentario();
                $cliente_comentario->fill((array) $comentario);
                $cliente_comentario->cliente_id = $cliente->id;
                if (!$cliente_comentario->save()) {
                    $this->errors ++;
                    $this->logErrors($cliente_comentario);
                } else {
                    $this->success ++;
                }
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults();
    }

    private function seedDomicilios() {
        $this->errors = 0;
        $this->success = 0;
        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($this->domicilios) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Domicilios-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        $clientes = App\Cliente::all(['id', 'usuario'])->groupBy('usuario');
        $clientes = empty($clientes) ? [] : $clientes->toArray();

        foreach ($this->domicilios as $domicilio) {
            if (array_key_exists($domicilio->usuario, $clientes) && !empty($codigo_postal = App\CodigoPostal::where('codigo_postal', $domicilio->codigo_postal)->first())) {
                $domicilio_nuevo = new App\Domicilio();
                $domicilio_nuevo->fill((array) $domicilio);
                $domicilio_nuevo->codigo_postal_id =$codigo_postal->id;
                if (!$domicilio_nuevo->save()) {
                    $this->errors ++;
                    $this->logErrors($domicilio_nuevo);
                } else {
                    $this->success ++;
                }
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults();
    }

    private function seedTelefonos() {
        $this->errors = 0;
        $this->success = 0;
        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($this->telefonos) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Telefonos-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        foreach ($this->telefonos as $telefono) {
            $cliente = App\Cliente::where('usuario', $telefono->usuario)->first();
            if (!empty($cliente)) {
                $domicilio = $cliente->domicilios->first();
                if (!empty($domicilio)) {
                    $telefono_nuevo = new App\Telefono();
                    $telefono_nuevo->fill(array_merge((array) $telefono, [
                        'domicilio_id' => $domicilio->id
                    ]));
                    if (!$telefono_nuevo->save()) {
                        $this->errors ++;
                        $this->logErrors($telefono_nuevo);
                    } else {
                        $this->success ++;
                    }
                }
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults();
    }

    private function logErrors(Model $model) {
        Log::error('Error en seed de ' . get_class($model), [
            'model'  => $model,
            'errors' => $model->errors
        ]);
    }

    private function printErrors() {
        $this->command->getOutput()->writeLn("<error>Unsuccessful: {$this->errors}</error>");
    }

    private function printResults() {
        $this->command->getOutput()->writeLn("<info>Seeded: {$this->success}</info>");
    }
}
