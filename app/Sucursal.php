<?php

namespace App;


class Sucursal extends LGGModel {

    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = ['clave', 'nombre', 'horarios', 'ubicacion'];
    public static $rules = [
        'clave'        => 'required|string|size:8|alpha|unique:sucursales',
        'nombre'       => 'required|string|max:45|alpha',
        'ubicacion'    => 'max:45',
        'horarios'     => 'required',
        'proveedor_id' => 'required|integer',
        'domicilio_id' => 'required|integer'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        Sucursal::creating(function ($sucursal)
        {
            $sucursal->clave = strtoupper($sucursal->clave);
            if (!$sucursal->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene el proveedor asociado a la sucursal
     * @return App\Proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    /**
     * Obtiene el domicilio asociado a la sucursal
     * @return App\Domicilio
     */
    public function domicilio()
    {
        return $this->belongsTo('App\Domicilio');
    }

    /**
     * Obtiene los empleados asociados a la sucursal
     * @return array
     */
    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }
}
