<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class Empleado extends LGGModel {

    protected $table = 'empleados';

    public $timestamps = false;

    protected $fillable = ['nombre', 'usuario', 'password', 'activo', 'puesto', 'access_token'];
    public static $rules = [
        'nombre'                => 'required|max:100|alpha',
        'usuario'               => 'required|max:20|alpha_dash|unique:empleados',
        'password'              => 'required|max:64|different:usuario',
        'activo'                => 'required|boolean',
        'puesto'                => 'alpha_dash',
        'fecha_cambio_password' => 'date',
        'fecha_ultimo_ingreso'  => 'date',
        'access_token'          => 'max:20|unique:empleados'
    ];

    /**
     * Define the model hooks
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

}
