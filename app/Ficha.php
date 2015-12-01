<?php

namespace App;


class Ficha extends LGGModel {

    protected $table = "fichas";
    public $timestamps = true;
    protected $fillable = ['producto_id', 'calidad', 'titulo', 'revisada'];

    public static $rules = [
        'producto_id' => 'integer|required|unique:fichas',
        'calidad'     => "string|max:45|in:'INTERNO','FABRICANTE','ICECAT','NOEDITOR'",
        'titulo'      => 'string|required|max:50',
        'revisada'    => 'boolean'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Ficha::creating(function ($model) {
            return $model->isValid();
        });
        Ficha::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['producto_id'] = 'integer|required|unique:fichas,id,' . $model->id;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el producto para el cual está definida esta ficha
     * @return \App\Producto
     */
    public function producto(){
        return $this->belongsTo('App\Producto');
    }

}
