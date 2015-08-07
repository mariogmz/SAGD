<?php

namespace App;


class Reposicion extends LGGModel {

    protected $table = "reposiciones";
    public $timestamps = true;
    protected $fillable = ['serie', 'producto_id', 'garantia_id', 'proveedor_id'];

    public static $rules = [
        'serie'        => 'required|string|max:45',
        'producto_id'  => 'required|integer',
        'garantia_id'  => 'required|integer',
        'proveedor_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Reposicion::creating(function ($model) {
            return $model->isValid();
        });
        Reposicion::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el producto asociado a la reposicion
     * @return App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto');
    }

    /**
     * Obtiene la garantia en la cual fue efectuada la reposicion
     * @return App\Garantia
     */
    public function garantia() {
        return $this->belongsTo('App\Garantia');
    }

    /**
     * Obtiene el proveedor del cual se obtuvo una reposicion
     * @return App\Proveedor
     */
    public function proveedor() {
        return $this->belongsTo('App\Proveedor');
    }

}
