<?php

namespace App;

class EntradaDetalle extends LGGModel
{
    //
    protected $table = "entradas_detalles";
    public $timestamps = true;
    protected $fillable = ['costo', 'cantidad', 'importe',
        'entrada_id', 'producto_id', 'sucursal_id', 'producto_movimiento_id'];

    public static $rules = [
        'costo' => 'required|numeric|min:0.0',
        'cantidad' => 'required|integer|min:0',
        'importe' => 'required|numeric|min:0.0',
        'entrada_id' => 'required|integer',
        'producto_id' => 'required|integer',
        'sucursal_id' => 'required|integer',
        'producto_movimiento_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        EntradaDetalle::creating(function($model){
            return $model->isValid();
        });
        EntradaDetalle::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene la Entrada asociada con la Entrada Detalle
    * @return App\Entrada
    */
    public function entrada()
    {
        return $this->belongsTo('App\Entrada', 'entrada_id');
    }


    /**
    * Obtiene el Producto asociado con la Entrada Detalle
    * @return App\Producto
    */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
    * Obtiene la Sucursal asociada con la Entrada Detalle
    * @return App\Sucursal
    */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
    * Obtiene el Movimiento del Producto asociado con la Entrada Detalle
    * @return App\ProductoMovimiento
    */
    public function productoMovimiento()
    {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }
}
