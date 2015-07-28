<?php

namespace App;

class ProductoSucursal extends LGGModel
{
    //
    protected $table = "productos_sucursales";
    public $timestamps = false;
    protected $fillable = [];

    public static $rules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ProductoSucursal::creating(function($ps){
            if ( !$ps->isValid() ){
                return false;
            }
            return true;
        });
    }

    /**
     * Obtiene la Existencia asociado al producto sucursal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function existencias()
    {
        return $this->hasMany('App\Existencia', 'productos_sucursales_id');
    }

    /**
     * Obtiene la Sucursal asociada al producto sucursal
     * @return App\Sucursal
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }


    /**
     * Obtiene los precios asociados
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function precios()
    {
        return $this->hasMany('App\Precio', 'producto_sucursal_id');
    }

    /**
     * Obtiene el producto asociado
     * @return App\Producto
     */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }
}
