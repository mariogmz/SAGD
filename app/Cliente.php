<?php

namespace App;


use App\Events\ClienteCreado;
use DB;
use Illuminate\Support\MessageBag;

/**
 * App\Cliente
 *
 * @property integer $id
 * @property string $usuario
 * @property string $nombre
 * @property string $fecha_nacimiento
 * @property string $sexo
 * @property string $ocupacion
 * @property string $fecha_verificacion_correo
 * @property string $fecha_expira_club_zegucom
 * @property string $referencia_otro
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $cliente_estatus_id
 * @property integer $sucursal_id
 * @property integer $cliente_referencia_id
 * @property integer $empleado_id
 * @property integer $vendedor_id
 * @property integer $rol_id
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\ClienteEstatus $estatus
 * @property-read \App\ClienteReferencia $referencia
 * @property-read \App\Empleado $empleado
 * @property-read \App\Empleado $vendedor
 * @property-read \App\Sucursal $sucursal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Empleado[] $empleados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ClienteComentario[] $comentarios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ClienteAutorizacion[] $autorizaciones
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PaginaWebDistribuidor[] $paginasWebDistribuidores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domicilio[] $domicilios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServicioSoporte[] $serviciosSoportes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialReceptor[] $razonesSociales
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereSexo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereOcupacion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereFechaVerificacionCorreo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereFechaExpiraClubZegucom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereReferenciaOtro($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereClienteEstatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereClienteReferenciaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereVendedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereRolId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Cliente whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Cliente extends LGGModel {

    protected $table = "clientes";
    public $timestamps = true;
    protected $fillable = ['usuario', 'nombre', 'fecha_nacimiento',
        'sexo', 'ocupacion', 'fecha_verificacion_correo',
        'fecha_expira_club_zegucom', 'referencia_otro',
        'cliente_estatus_id', 'rol_id', 'sucursal_id', 'cliente_referencia_id',
        'empleado_id', 'vendedor_id'];

    public static $rules = [
        'usuario'                   => 'required|max:20|unique:clientes,usuario',
        'nombre'                    => 'required|max:200',
        'fecha_nacimiento'          => 'date',
        'sexo'                      => 'required|string|in:HOMBRE,MUJER',
        'ocupacion'                 => 'max:45',
        'fecha_verificacion_correo' => 'date',
        'fecha_expira_club_zegucom' => 'date',
        'referencia_otro'           => 'max:50',
        'cliente_estatus_id'        => 'required|integer',
        'rol_id'                    => 'required|integer',
        'sucursal_id'               => 'required|integer',
        'cliente_referencia_id'     => 'integer',
        'empleado_id'               => 'integer',
        'vendedor_id'               => 'integer',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Cliente::creating(function ($cliente) {
            if (empty($cliente->usuario)) {
                $cliente->usuario = str_replace(".", "", microtime(true));
            }

            return $cliente->isValid();
        });
        Cliente::updating(function ($cliente) {
            $cliente->updateRules = self::$rules;
            $cliente->updateRules['usuario'] = 'required|max:20|unique:clientes,usuario,' . $cliente->id;

            return $cliente->isValid('update');
        });
    }

    /**
     * Guardar el modelo a la base de datos
     * @param array $datos
     * @return bool
     */
    public function guardar(array $datos) {
        if ($this->save()) {
            // Ya que el evento ocupa un parámetro, no se llama desde Cliente::created
            event(new ClienteCreado($this, $datos));

            return true;
        } else {
            return false;
        }
    }

    /**
     * Encapsula todas las operaciones solicitadas sobre el cliente y sus modelos relacionados
     * de domicilios con teléfonos, y tabuladores.
     * @param array $datos
     * @return bool
     */
    public function actualizar($datos) {

        if ($this->update($datos)) {
            DB::beginTransaction();
            $domicilios_guardados = $this->guardarDomicilios($datos);

            if ($domicilios_guardados) {
                DB::commit();
            } else {
                $this->errors = empty($this->errors) ? new MessageBag() : $this->errors;
                $this->errors->add('Domicilios', 'Algunos domicilios y/o teléfonos están vacíos o incorrectos.');
                DB::rollBack();
            }

            DB::beginTransaction();
            $tabuladores_actualizados = $this->actualizarTabuladores($datos);

            if ($tabuladores_actualizados) {
                DB::commit();

            } else {
                $this->errors = empty($this->errors) ? new MessageBag() : $this->errors;
                $this->errors->add('Tabuladores', 'No se pudieron guardar los tabuladores.');
                DB::rollBack();
            }

            return $domicilios_guardados && $tabuladores_actualizados;
        } else {

            return false;
        }
    }

    /**
     * Recibe un array de domicilios con sus relaciones, separa los que van a ser creados,
     * de los que van a ser actualizados y los que van a ser eliminados, de acuerdo
     * al parametro de "action" que tengan:
     *
     * - 0. Crear nuevo
     * - 1. Actualizar existente
     * - 2. Eliminar registro
     *
     * @param array $data
     * @return bool
     */
    private function guardarDomicilios($data) {
        $solo_telefonos = [];
        $nuevos = [];
        $por_actualizar = [];
        $por_eliminar = [];
        foreach ($data['domicilios'] as $domicilio) {
            if (array_key_exists('action', $domicilio)) {
                switch ($domicilio['action']) {
                    case 0:
                        array_push($nuevos, $domicilio);
                        break;
                    case 1:
                        array_push($por_actualizar, $domicilio);
                        break;
                    case 2:
                        array_push($por_eliminar, $domicilio);
                        break;
                }
            } else {
                array_push($solo_telefonos, $domicilio);
            }
        }

        return ($this->crearNuevosDomicilios($nuevos)
            && $this->actualizarDomicilios($por_actualizar)
            && $this->eliminarDomicilios($por_eliminar)
            && $this->actualizarDomicilios($solo_telefonos, true));
    }

    /**
     * Realiza la creación de nuevos domicilios junto con los nuevos teléfonos
     * asociados.
     * @param array $domicilios
     * @return bool
     */
    private function crearNuevosDomicilios(array $domicilios) {
        foreach ($domicilios as $domicilio) {
            $nuevo_domicilio = new Domicilio();
            $nuevo_domicilio->fill($domicilio);

            if ($nuevo_domicilio->isValid()) {
                $this->domicilios()->save($nuevo_domicilio);
                if (array_key_exists('telefonos', $domicilio)) {
                    foreach ($domicilio['telefonos'] as $telefono) {

                        $nuevo_telefono = new Telefono();
                        $nuevo_telefono->fill($telefono);
                        if ($nuevo_telefono->isValid()) {
                            $nuevo_domicilio->telefonos()->save($nuevo_telefono);
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * Realiza la actualización de los domicilios, y de cada uno de estos, realiza
     * la acción solicitada sobre los teléfonos asociados.
     * @param array $domicilios
     * @return bool
     */
    private function actualizarDomicilios(array $domicilios, $solo_telefonos = false) {
        foreach ($domicilios as $domicilio_raw) {
            $domicilio = Domicilio::find($domicilio_raw['id']);
            if (empty($domicilio)
                || ($solo_telefonos ? false : !$domicilio->update($domicilio_raw))
                || !$domicilio->guardarTelefonos($domicilio_raw['telefonos'])
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Elimina los domicilios solicitados
     * @param array $domicilios
     * @return bool
     */
    private function eliminarDomicilios(array $domicilios) {
        $domicilios_ids = collect($domicilios)->lists('id');

        return (count($domicilios) == 0 || Domicilio::whereIn('id', $domicilios_ids)->delete() > 0);
    }

    /**
     * Actualiza los tabuladores
     * @param array $data
     * @return bool
     */
    private function actualizarTabuladores($data) {
        foreach ($data['tabuladores'] as $tabulador_raw) {
            $tabulador = Tabulador::find($tabulador_raw['id']);
            if (empty($tabulador) || !$tabulador->update($tabulador_raw)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Obtiene el Cliente Estatus asociado con el Cliente
     * @return \App\ClienteEstatus
     */
    public function estatus() {
        return $this->belongsTo('App\ClienteEstatus', 'cliente_estatus_id');
    }


    /**
     * Obtiene el Cliente Referencia asociado con el Cliente
     * @return \App\ClienteReferencia
     */
    public function referencia() {
        return $this->belongsTo('App\ClienteReferencia', 'cliente_referencia_id');
    }


    /**
     * Obtiene el Empleado asociado con el Cliente
     * @return \App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }

    /**
     * Obtiene el Vendedor asociado con el Cliente
     * @return \App\Empleado
     */
    public function vendedor() {
        return $this->belongsTo('App\Empleado', 'vendedor_id');
    }


    /**
     * Obtiene la Sucursal asociada con el Cliente
     * @return \App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
     * Obtiene los Empleados asociado con el Cliente
     * @return \Illuminate\Database\Eloquent\Collection::class
     */
    public function empleados() {
        return $this->belongsToMany('App\Empleado', 'clientes_comentarios',
            'cliente_id', 'empleado_id');
    }

    /**
     * Obtiene los Comentarios asociado con el Cliente
     * @return \Illuminate\Database\Eloquent\Collection::class
     */
    public function comentarios() {
        return $this->hasMany('App\ClienteComentario', 'cliente_id');
    }


    /**
     * Obtiene las Autorizaciones asociado con el Cliente
     * @return \Illuminate\Database\Eloquent\Collection::class
     */
    public function autorizaciones() {
        return $this->hasMany('App\ClienteAutorizacion', 'cliente_id');
    }

    /**
     * Obtiene las paginas web distribuidor asociado con el Cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function paginasWebDistribuidores() {
        return $this->hasMany('App\PaginaWebDistribuidor', 'cliente_id');
    }


    /**
     * Obtiene los Domicilios asociado con el Cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function domicilios() {
        return $this->belongsToMany('App\Domicilio', 'domicilios_clientes',
            'cliente_id', 'domicilio_id');
    }

    /**
     * Obtiene los soportes que ha solicitado el cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function serviciosSoportes() {
        return $this->hasMany('App\ServicioSoporte');
    }

    /**
     * Obtiene los RMAs que ha solicitado el cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas() {
        return $this->hasMany('App\Rma');
    }

    /**
     * Obtiene las Razones Sociales asociadas con el Cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function razonesSociales() {
        return $this->hasMany('App\RazonSocialReceptor', 'cliente_id');
    }

    /**
     * Obtiene el User morphable con el Cliente
     * @return \App\User
     */
    public function user() {
        return $this->morphOne('App\User', 'morphable');
    }

    /**
     * Obtiene los tabuladores asociados a este cliente
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tabuladores() {
        return $this->hasMany('App\Tabulador');
    }

    /**
     * Obtiene el rol asociado al cliente
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rol() {
        return $this->belongsTo('App\Rol');
    }
}
