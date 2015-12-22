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

    private $relacion;

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
//            DB::commit();
            DB::rollBack();
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

        $this->relacion = [];
    }

    private function obtenerDatos() {
        // Clientes
        $this->clientes = $this->legacy->select("
        SELECT
          TRIM(clave) AS clave,
          IF(usuario IS NULL OR usuario = '',LOWER(TRIM(clave)),LOWER(TRIM(usuario))) AS usuario,
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
          TRIM(clave) AS clave,
          IF(usuario IS NULL OR usuario = '',LOWER(TRIM(clave)),LOWER(TRIM(usuario))) AS usuario,
          TRIM(email) AS email,
          password
        FROM clientes
        WHERE
          email IS NOT NULL
          AND email <> '';");

        // Comentarios
        $this->comentarios = $this->legacy->select("
        SELECT
          TRIM(cliente_clave) AS clave,
          comentario,
          1 AS empleado_id,
          fecha AS updated_at
        FROM cliente_comentario;");

        // Domicilios
        $this->domicilios = $this->legacy->select("
       SELECT
          TRIM(clave) AS clave,
          IF(domicilio = '' OR domicilio IS NULL,IFNULL(lugar,'MEXICO'),domicilio) AS calle,
          lugar AS localidad,
          TRIM(cp) AS codigo_postal
        FROM clientes
        WHERE
          cp <> 0 AND cp <> 'NULL'
          AND lugar <> '' AND lugar <> 'NULL';");

        // Teléfonos
        $this->telefonos = $this->legacy->select("
        SELECT
          TRIM(clave) AS clave,
          telefono AS numero,
          'FIJO' AS tipo
        FROM clientes
        WHERE
          telefono IS NOT NULL
          AND telefono <> ''
          AND telefono <> 'NULL'
        UNION
        SELECT
          TRIM(clave) AS clave,
          celular AS numero,
          'CELULAR' AS tipo
        FROM clientes
        WHERE
          celular IS NOT NULL
          AND celular <> ''
          AND celular <> 'NULL';");
    }

    private function seedClientes() {
        $total = count($this->clientes);
        $this->progress_bar = new ProgressBar($this->command->getOutput(), $total + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();
        $taken_usernames = [];

        foreach ($this->clientes as $cliente) {
            $nuevo_cliente = new App\Cliente();
            // Workaround when the name is empty (which shouldn't)
            if (empty($cliente->nombre)) {
                $cliente->nombre = $cliente->usuario;
            }
            // Workaround when the username was already taken
            if (in_array($cliente->usuario, $taken_usernames)) {
                $cliente->usuario = $cliente->clave;
            }

            array_push($taken_usernames, $cliente->usuario);
            $nuevo_cliente->fill((array) $cliente);

            if (!$nuevo_cliente->save()) {
                $this->errors ++;
                $this->logErrors($nuevo_cliente);
            } else {
                $this->relacion[$cliente->clave] = $nuevo_cliente->id;
                $this->success ++;
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults($total);
    }

    private function seedUsuarios() {
        $total = count($this->usuarios);
        $this->errors = 0;
        $this->success = 0;
        $usuarios = $this->usuarios;
        reindexar('clave', $usuarios);
        $usuarios = array_intersect_key($usuarios, $this->relacion);

        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($usuarios) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Usuarios-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        foreach ($usuarios as $usuario) {
            $nuevo_usuario = new App\User();
            $nuevo_usuario->email = $usuario['email'];
            $nuevo_usuario->password = \Hash::make($usuario['password']);
            $nuevo_usuario->morphable_id = $this->relacion[$usuario['clave']];
            $nuevo_usuario->morphable_type = 'App\Cliente';
            if (!$nuevo_usuario->save()) {
                $this->errors ++;
                $this->logErrors($nuevo_usuario);
            } else {
                $this->success ++;
            }

            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults($total);
    }

    private function seedComentarios() {
        $total = count($this->comentarios);
        $this->errors = 0;
        $this->success = 0;

        $comentarios = $this->comentarios;
        reindexar('clave', $comentarios);
        $comentarios = array_intersect_key($comentarios, $this->relacion);

        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($comentarios) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Comentarios-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        foreach ($comentarios as $comentario) {
            $cliente_comentario = new App\ClienteComentario();
            $cliente_comentario->fill((array) $comentario);
            $cliente_comentario->cliente_id = $this->relacion[$comentario['clave']];
            if (!$cliente_comentario->save()) {
                $this->errors ++;
                $this->logErrors($cliente_comentario);
            } else {
                $this->success ++;
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults($total);
    }

    private function seedDomicilios() {
        $total = count($this->domicilios);
        $this->errors = 0;
        $this->success = 0;
        $domicilios = $this->domicilios;
        reindexar('clave', $domicilios);
        $domicilios = array_intersect_key($domicilios, $this->relacion);

        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($domicilios) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Domicilios-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();

        foreach ($domicilios as $domicilio) {
            if (!empty($codigo_postal = App\CodigoPostal::where('codigo_postal', $domicilio['codigo_postal'])->first())) {
                $domicilio_nuevo = new App\Domicilio();
                $domicilio_nuevo->fill((array) $domicilio);
                $domicilio_nuevo->codigo_postal_id = $codigo_postal->id;
                if ($domicilio_nuevo->save()) {
                    $cliente = App\Cliente::find($this->relacion[$domicilio['clave']]);
                    $cliente->domicilios()->attach($domicilio_nuevo);
                    $this->success ++;
                } else {
                    $this->errors ++;
                    $this->logErrors($domicilio_nuevo);
                }
            }else{
                Log::alert('Codigo postal no encontrado.', [
                    'codigo_postal' => $domicilio['codigo_postal']
                ]);
            }
            $this->progress_bar->advance();
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults($total);
    }

    private function seedTelefonos() {
        $total = count($this->telefonos);
        $this->errors = 0;
        $this->success = 0;

        $telefonos = collect($this->telefonos)->groupBy('clave')->toArray();
        $telefonos = array_intersect_key($telefonos, $this->relacion);
        $this->fixFormat($telefonos);

        $this->progress_bar = new ProgressBar($this->command->getOutput(), count($telefonos) + 1);
        $this->progress_bar->setFormat("<info>Seeding:</info> Telefonos-Clientes : [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s%");
        $this->progress_bar->start();


        foreach ($telefonos as $telefono) {
            foreach ($telefono as $numero) {
                if (!empty($cliente = App\Cliente::find($this->relacion[$numero['clave']]))) {
                    $telefono_nuevo = new App\Telefono();
                    $telefono_nuevo->fill((array) $numero);
                    $domicilio = $cliente->domicilios()->first();
                    if (empty($domicilio)) {
                        $this->errors ++;
                        Log::error('Error en seed de App\Telefono, domicilio no existente para cliente.', [
                            'cliente'  => $cliente,
                            'telefono' => $numero
                        ]);
                    } else {
                        $telefono_nuevo->domicilio_id = $domicilio->id;
                        if ($telefono_nuevo->save()) {
                            $this->success ++;
                        } else {
                            $this->errors ++;
                            $this->logErrors($telefono_nuevo);
                        }
                    }
                }
                $this->progress_bar->advance();
            }
        }
        $this->progress_bar->finish();
        $this->command->getOutput()->writeln("");
        $this->printErrors();
        $this->printResults($total);
    }

    private function logErrors(Model $model) {
        Log::error('Error en seed de ' . get_class($model), [
            'model'  => $model,
            'errors' => $model->errors
        ]);
    }

    private function printErrors() {
        if ($this->errors > 0) {
            $this->command->getOutput()->writeLn("<error>Unsuccessful: {$this->errors}</error>");
            $this->command->getOutput()->writeLn("<error>This may be because some legacy records didn't match the new model validation rules, check laravel logs for additional info</error>");
        }
    }

    private function printResults($total) {
        if ($this->success < $total) {
            $this->command->getOutput()->writeLn("<info>Seeded: {$this->success} of {$total}</info>");
            $this->command->getOutput()->writeLn("<info>The difference may be because some clients weren't seeded, and they have some dependencies</info>");
        } else {
            $this->command->getOutput()->writeLn("<info>Done!</info>");
        }
    }

    /**
     * This method performs a regexp replace on an effort to give a correct format the the phone numbers
     * @param array $telephones
     */
    private function fixFormat(array &$telephones) {
        $pattern = '/\D/';
        foreach ($telephones as &$telephone) {
            foreach ($telephone as &$number) {
                $number = (array) $number;
                $number['numero'] = preg_replace($pattern, "", $number['numero']);
            }
        }
    }
}
