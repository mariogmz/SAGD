<?php

namespace App;

class ProductoMovimiento extends LGGModel
{
    //
    protected $table = "productos_movimientos";
    public $timestamps = true;
    protected $fillable = ['movimiento', 'entraron', 'salieron',
        'existencias_antes', 'existencias_despues', 'producto_id'];

    public static $rules = [
        'movimiento' => 'required|max:100',
        'entraron' => 'integer|min:0',
        'salieron' => 'integer|min:0',
        'existencias_antes' => 'integer|min:0',
        'existencias_despues' => 'integer|min:0',
    ];

    public $updateRules= [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ProductoMovimiento::creating(function($pm){
            $pm->entraron || $pm->entraron = 0;
            $pm->salieron || $pm->salieron = 0;
            $pm->existencias_antes || $pm->existencias_antes = 0;
            $pm->existencias_despues || $pm->existencias_despues = 0;
            if ( !$pm->isValid() ){
                return false;
            }
            return true;
        });
        ProductoMovimiento::updating(function($pm){
            $pm->updateRules = self::$rules;
            $pm->entraron || $pm->entraron = 0;
            $pm->salieron || $pm->salieron = 0;
            $pm->existencias_antes || $pm->existencias_antes = 0;
            $pm->existencias_despues || $pm->existencias_despues = 0;
            return $pm->isValid('update');
        });
    }

    /**
     * Obtiene el Producto asociado al Movimiento
     * @return App\Producto
     */
    public function producto()
    {
        return $this->belongsTo('App\Producto');
    }

    /**
     * Obtiene el detalle del rma
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmaDetalles(){
        return $this->hasMany('App\RmaDetalle');
    }


    /**
    * Obtiene las Entradas Detalles asociadas con el Producto Movimiento
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function entradasDetalles()
    {
        return $this->hasMany('App\EntradaDetalle', 'producto_movimiento_id');
    }


    /**
    * Obtiene las Salidas Detalles asociadas con el Producto Movimiento
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function salidasDetalles()
    {
        return $this->hasMany('App\SalidaDetalle', 'producto_movimiento_id');
    }


    /**
    * Obtiene las Transferencias Detalles asociadas con el Producto Movimiento
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferenciasDetalles()
    {
        return $this->hasMany('App\TransferenciaDetalle', 'producto_movimiento_id');
    }


    /**
    * Obtiene los Apartados Detalles asociados con el Producto Movimiento
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function apartadosDetalles()
    {
        return $this->hasMany('App\ApartadoDetalle', 'producto_movimiento_id');
    }
}
