<?php

namespace App;


class Empleado extends LGGModel {

    protected $table = 'empleados';

    public $timestamps = false;

    protected $fillable = ['nombre', 'usuario', 'password', 'activo', 'puesto', 'access_token'];
    public static $rules = [
        'nombre'                => ['required', 'max:100'],
        'usuario'               => 'required|max:20|unique:empleados',
        'password'              => 'required|max:64|different:usuario',
        'activo'                => 'required|boolean',
        'puesto'                => 'string|max:45',
        'fecha_cambio_password' => 'required|date',
        'fecha_ultimo_ingreso'  => 'date',
        'access_token'          => 'max:20|unique:empleados'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        Empleado::creating(function ($empleado)
        {
            if (!$empleado->isValid())
            {
                return false;
            }

            return true;
        });
        Empleado::updating(function($empleado){
            $empleado->updateRules = self::$rules;
            $empleado->updateRules['usuario'] .= ',usuario,'.$empleado->id;
            $empleado->updateRules['access_token'] .= ',access_token,'.$empleado->id;
            return $empleado->isValid('update');
        });
    }

    /**
     * Obtiene todos los logs de acceso asociados al empleado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function logsAccesos()
    {
        return $this->hasMany('App\LogAcceso');
    }

    /**
     * Obtiene los datos de contacto asociados al empleado
     * @return App\DatoContacto
     */
    public function datoContacto()
    {
        return $this->hasOne('App\DatoContacto');
    }

    /**
     * Obtiene la sucursal a la que pertenece el empleado
     * @return App\Sucursal
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene los soportes que ha atendido el empleado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function serviciosSoportes()
    {
        return $this->hasMany('App\ServicioSoporte');
    }

    /**
     * Obtiene los RMAs que ha solicitado el cliente
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas()
    {
        return $this->hasMany('App\Rma');
    }


    /**
    * Obtiene las Salidas asociadas con el Empleado
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function salidas()
    {
        return $this->hasMany('App\Salida', 'empleado_id');
    }


    /**
    * Obtiene las Entradas asociadas con el Empleado
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function entradas()
    {
        return $this->hasMany('App\Entrada', 'empleado_id');
    }


    /**
    * Obtiene las Transferencias asociadas con el Empleado como Origen
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferenciasOrigen()
    {
        return $this->hasMany('App\Transferencia', 'empleado_origen_id');
    }


    /**
    * Obtiene las Transferencias asociadas con el Empleado como Destino
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferenciasDestino()
    {
        return $this->hasMany('App\Transferencia', 'empleado_destino_id');
    }


    /**
    * Obtiene las Transferencias asociadas con el Empleado como Revision
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferenciasRevision()
    {
        return $this->hasMany('App\Transferencia', 'empleado_revision_id');
    }
}
