<?php

namespace App;

class Precio extends LGGModel
{
    //
    protected $table = "precios";
    public $timestamps = false;
    protected $fillable = ['costo', 'precio_1', 'precio_2', 'precio_3',
    'precio_4', 'precio_5', 'precio_6', 'precio_7', 'precio_8', 'precio_9',
    'precio_10'];

    public static $rules = [
        'costo' => 'required|numeric|min:0.0',
        'precio_1' => 'required|numeric|min:0.0',
        'precio_2' => 'required|numeric|min:0.0',
        'precio_3' => 'required|numeric|min:0.0',
        'precio_4' => 'required|numeric|min:0.0',
        'precio_5' => 'required|numeric|min:0.0',
        'precio_6' => 'required|numeric|min:0.0',
        'precio_7' => 'required|numeric|min:0.0',
        'precio_8' => 'required|numeric|min:0.0',
        'precio_9' => 'required|numeric|min:0.0',
        'precio_10' => 'required|numeric|min:0.0',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Precio::creating(function($precio){
            if ( !$precio->isValid() ){
                return false;
            }
            return true;
        });
        Precio::updating(function($precio){
            $precio->updateRules = self::$rules;
            return $precio->isValid('update');
        });
    }

    /**
     * Obtiene el producto sucursal/proveedor asociado
     * @return App\ProductoSucursal
     */
    public function productoSucursal()
    {
        return $this->belongsTo('App\ProductoSucursal', 'producto_sucursal_id');
    }

    public function producto()
    {
        return $this->productoSucursal->belongsTo('App\Producto', 'producto_id');
    }
}
