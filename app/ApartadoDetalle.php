<?php

namespace App;

class ApartadoDetalle extends LGGModel
{
    //
    protected $table = "apartados_detalles";
    public $timestamps = true;
    protected $fillable = ['cantidad', 'existencia_antes', 'existencia_despues',
        'apartado_id', 'producto_id', 'producto_movimiento_id'];

    public static $rules = [
        'cantidad' => 'required|integer|min:0',
        'existencia_antes' => 'required|integer|min:0',
        'existencia_despues' => 'required|integer|min:0',
        'apartado_id' => 'required|integer',
        'producto_id' => 'required|integer',
        'producto_movimiento_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ApartadoDetalle::creating(function($model){
            return $model->isValid();
        });
        ApartadoDetalle::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Apartado asociado con el Detalle
    * @return App\Apartado
    */
    public function apartado()
    {
        return $this->belongsTo('App\Apartado', 'apartado_id');
    }


    /**
    * Obtiene el Producto asociado con el Detalle
    * @return App\Producto
    */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
    * Obtiene el Producto Movimiento asociado con el Detalle
    * @return App\ProductoMovimiento
    */
    public function productoMovimiento()
    {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }
}
