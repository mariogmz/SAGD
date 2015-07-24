<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Sucursal extends Model {

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
