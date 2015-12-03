<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pretransferencia extends LGGModel
{
    protected $table = 'pretransferencias';
    public $timestamps = true;
    protected $fillable = ['producto_id', 'sucursal_origen_id', 'sucursal_destino_id', 'cantidad'];

    public static $rules = [
        'producto_id'           => 'required|int|',
        'sucursal_origen_id'    => 'required|int|',
        'sucursal_destino_id'   => 'required|int|',
        'cantidad'              => 'required|int|min:0'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        parent::boot();
        Pretransferencia::creating(function($model) {
            return $model->isValid();
        });
        Pretransferencia::updating(function($model) {
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Producto asociado con la Pretransferencia
    * @return App\Producto
    */
    public function producto()
    {
        return $this->belongsTo('App\Producto', 'producto_id');
    }


    /**
    * Obtiene la Sucursal de origen asociada con la Pretransferencia
    * @return App\Sucursal
    */
    public function origen()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_origen_id');
    }


    /**
    * Obtiene la Sucursal de destino asociada con la Pretransferencia
    * @return App\Sucursal
    */
    public function destino()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_destino_id');
    }
}
