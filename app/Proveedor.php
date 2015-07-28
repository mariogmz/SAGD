<?php

namespace App;


class Proveedor extends LGGModel {

    protected $table = 'proveedores';
    public $timestamps = false;

    protected $fillable = ['clave', 'razon_social', 'externo', 'pagina_web'];
    public static $rules = [
        'clave'        => 'required|size:4|unique:proveedores|alpha',
        'razon_social' => 'required',
        'externo'      => 'required|boolean',
        'pagina_web'   => 'url'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        Proveedor::creating(function ($proveedor)
        {
            $proveedor->clave = strtoupper($proveedor->clave);
            if (!$proveedor->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene las sucursales asociadas al proveedor
     * @return array
     */
    public function sucursales()
    {
        return $this->hasMany('App\Sucursal');
    }


}
