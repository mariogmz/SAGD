<?php

namespace App;

class TransferenciaDetalle extends LGGModel
{
    //
    protected $table = "transferencias_detalles";
    public $timestamps = true;
    protected $fillable = ['cantidad', 'existencia_origen_antes',
        'existencia_origen_despues', 'existencia_destino_antes', 'existencia_destino_despues'];

    public static $rules = [
        'cantidad' => 'required|integer|min:0',
        'existencia_origen_antes' => 'required|integer|min:0',
        'existencia_origen_despues' => 'required|integer|min:0',
        'existencia_destino_antes' => 'required|integer|min:0',
        'existencia_destino_despues' => 'required|integer|min:0',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        TransferenciaDetalle::creating(function($model){
            return $model->isValid();
        });
        TransferenciaDetalle::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene la Transferencia asociada con el Detalle
    * @return App\Transferencia
    */
    public function transferencia()
    {
        return $this->belongsTo('App\Transferencia', 'transferencia_id');
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
    * Obtiene el ProductoMovimiento asociado con el Detalle
    * @return App\ProductoMovimiento
    */
    public function productoMovimiento()
    {
        return $this->belongsTo('App\ProductoMovimiento', 'producto_movimiento_id');
    }
}
