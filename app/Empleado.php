<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class Empleado extends Model {

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

    public function isValid()
    {
        $validation = Validator::make($this->attributes, static::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();
        return false;
    }
}
