<?php

namespace App;

use App\Events\EmpleadoCreado;
use App\DatoContacto;
use Sagd\SafeTransactions;


/**
 * App\Empleado
 *
 * @property integer $id
 * @property string $nombre
 * @property string $usuario
 * @property string $password
 * @property boolean $activo
 * @property string $puesto
 * @property string $fecha_cambio_password
 * @property string $fecha_ultimo_ingreso
 * @property string $access_token
 * @property integer $sucursal_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\LogAcceso[] $logsAccesos
 * @property-read \App\DatoContacto $datoContacto
 * @property-read \App\Sucursal $sucursal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ServicioSoporte[] $serviciosSoportes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Salida[] $salidas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entrada[] $entradas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transferencia[] $transferenciasOrigen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transferencia[] $transferenciasDestino
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transferencia[] $transferenciasRevision
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Apartado[] $apartados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Apartado[] $desapartados
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Corte[] $cortes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaMovimiento[] $ventasMovimientos
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereUsuario($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereActivo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado wherePuesto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereFechaCambioPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereFechaUltimoIngreso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereAccessToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Empleado whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Empleado extends LGGModel {

    use SafeTransactions;

    protected $table = 'empleados';

    public $timestamps = false;

    protected $fillable = ['nombre', 'usuario', 'activo', 'puesto', 'fecha_cambio_password', 'fecha_ultimo_ingreso', 'sucursal_id'];
    public static $rules = [
        'nombre'                => ['required', 'max:100'],
        'usuario'               => 'required|max:20|unique:empleados',
        'activo'                => 'required|boolean',
        'puesto'                => 'string|max:45',
        'fecha_cambio_password' => 'date',
        'fecha_ultimo_ingreso'  => 'date',
        'sucursal_id'           => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Empleado::creating(function ($empleado) {
            if (!$empleado->isValid()) {
                return false;
            }

            return true;
        });
        Empleado::updating(function ($empleado) {
            $empleado->updateRules = self::$rules;
            $empleado->updateRules['usuario'] .= ',usuario,' . $empleado->id;

            return $empleado->isValid('update');
        });
        Empleado::created(function ($empleado) {
            event(new EmpleadoCreado($empleado));
        });
    }

    /**
     * La actualizacion del modelo puede ocurrir independientemente si se mandaron
     * los parámetros de datos_contacto.
     * @param array $parametros
     * @return bool
     */
    public function actualizar($parametros)
    {
        $datoContactoParams = $parametros['dato_contacto'];
        if ($this->update($parametros)) {
            $datoContacto = $this->datoContacto;
            return $datoContacto->update($datoContactoParams);
        } else {
            return false;
        }
    }

    /**
     * @param array
     * @return bool
     */
    public function guardar($datosContactoParams)
    {
        $lambda = function() use ($datosContactoParams) {
            if ($this->save()) {
                $datoContacto = new DatoContacto($datosContactoParams);
                return $this->datoContacto()->save($datoContacto);
            } else {
                return false;
            }
        };
        return $this->safe_transaction($lambda);
    }

    /**
     * Esta funcion busca en App\User por el correo y regresa el morphable si es de tipo
     * App\Empleado
     * @param string $email
     * @return App\Empleado
     */
    public static function whereEmail($email)
    {
        $user = User::whereEmail($email)->first();
        if ($user && $user->morphable_type === Empleado::class) {
            return $user->morphable;
        }
        return null;
    }

    /**
     * Obtiene todos los logs de acceso asociados al empleado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function logsAccesos() {
        return $this->hasMany('App\LogAcceso');
    }

    /**
     * Obtiene los datos de contacto asociados al empleado
     * @return App\DatoContacto
     */
    public function datoContacto() {
        return $this->hasOne('App\DatoContacto');
    }

    /**
     * Obtiene la sucursal a la que pertenece el empleado
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene los soportes que ha atendido el empleado
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
     * Obtiene las Salidas asociadas con el Empleado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function salidas() {
        return $this->hasMany('App\Salida', 'empleado_id');
    }


    /**
     * Obtiene las Entradas asociadas con el Empleado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradas() {
        return $this->hasMany('App\Entrada', 'empleado_id');
    }


    /**
     * Obtiene las Transferencias asociadas con el Empleado como Origen
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasOrigen() {
        return $this->hasMany('App\Transferencia', 'empleado_origen_id');
    }


    /**
     * Obtiene las Transferencias asociadas con el Empleado como Destino
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasDestino() {
        return $this->hasMany('App\Transferencia', 'empleado_destino_id');
    }


    /**
     * Obtiene las Transferencias asociadas con el Empleado como Revision
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferenciasRevision() {
        return $this->hasMany('App\Transferencia', 'empleado_revision_id');
    }


    /**
     * Obtiene los Apartados asociados con el Empleado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function apartados() {
        return $this->hasMany('App\Apartado', 'empleado_apartado_id');
    }


    /**
     * Obtiene los Desapartados asociados con el Empleado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function desapartados() {
        return $this->hasMany('App\Apartado', 'empleado_desapartado_id');
    }

    /**
     * Obtiene los cortes que realizó el empleado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function cortes() {
        return $this->hasMany('App\Corte');
    }

    /**
     * Obtiene todos los movimientos de ventas realizados por el empleado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasMovimientos() {
        return $this->hasMany('App\VentaMovimiento');
    }


    /**
    * Obtiene el User morphable con el Empleado
    * @return App\User
    */
    public function user()
    {
        return $this->morphOne('App\User', 'morphable');
    }
}
