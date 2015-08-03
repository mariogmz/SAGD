<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

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

    public $updateRules = [];

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
        Sucursal::updating(function($sucursal){
            $sucursal->updateRules = self::$rules;
            $sucursal->updateRules['clave'] .= ',clave,'.$sucursal->id;
            return $sucursal->isValid('update');
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
     * Obtener los Productos relacionados con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function productos()
    {
        return $this->belongsToMany('App\Producto', 'productos_sucursales',
            'sucursal_id', 'producto_id');
    }

    /**
     * Obtiene los empleados asociados a la sucursal
     * @return array
     */
    public function empleados()
    {
        return $this->hasMany('App\Empleado');
    }

    /**
     * Obtener los RMAs generados en la sucursal
     * @return array
     */
    public function rmas(){
        return $this->hasMany('App\Rma');
    }


    /**
    * Obtiene las Salidas asociadas con la Sucursal
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function salidas()
    {
        return $this->hasMany('App\Salida', 'sucursal_id');
    }


    /**
    * Obtiene la Razon Social Emisora asociada con la Sucursal
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function razonesSocialesEmisores()
    {
        return $this->hasMany('App\RazonSocialEmisor', 'sucursal_id');
    }


    /**
    * Obtiene las Entradas Detalles asociadas con la Sucursal
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function entradasDetalles()
    {
        return $this->hasMany('App\EntradaDetalle', 'sucursal_id');
    }


    /**
    * Obtiene las Transferencias asociadas con la Sucursal como origen
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferenciasOrigen()
    {
        return $this->hasMany('App\Transferencia', 'sucursal_origen_id');
    }


    /**
    * Obtiene las Transferencias asociadas con la Sucursal como destino
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferenciasDestino()
    {
        return $this->hasMany('App\Transferencia', 'sucursal_destino_id');
    }
}
