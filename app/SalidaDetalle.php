<?php

namespace App;

class SalidaDetalle extends LGGModel
{
    //
    protected $table = "salidas_detalles";
    public $timestamps = true;
    protected $fillable = ['cantidad', 'producto_id', 'producto_movimiento_id',
        'salida_id'];

    public static $rules = [
        'cantidad' => 'required|integer',
        'producto_id' => 'required|integer',
        'producto_movimiento_id' => 'required|integer',
        'salida_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        SalidaDetalle::creating(function($model){
            return $model->isValid();
        });
        SalidaDetalle::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Producto asociado con la Salida Detalle
    * @return App\Producto::class
    */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
    * Obtiene el ProductoMovimiento asociado con la Salida Detalle
    * @return App\ProductoMovimiento
    */
    public function productoMovimiento()
    {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }


    /**
    * Obtiene la Salida asociada con la Salida Detalle
    * @return App\Salida
    */
    public function salida()
    {
        return $this->belongsTo('App\Salida', 'salida_id');
    }
}
