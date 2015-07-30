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
}
