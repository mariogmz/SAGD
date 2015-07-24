<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Sucursal extends Model {

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
     */
    public static function boot()
    {
        Sucursal::creating(function ($proveedor)
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
     * This method is responsible for validating the model
     *
     * @return bool
     */
    public function isValid()
    {
        $validation = Validator::make($this->attributes, static::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();

        return false;
    }
}
