<?php

namespace App;


/**
 * App\SucursalEnvio
 *
 * @property integer $id
 * @property boolean $genera_costo
 * @property integer $dias_max_envio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $sucursal_origen_id
 * @property integer $sucursal_destino_id
 * @property-read \App\Sucursal $sucursalOrigen
 * @property-read \App\Sucursal $sucursalDestino
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereGeneraCosto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereDiasMaxEnvio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereSucursalOrigenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalEnvio whereSucursalDestinoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class SucursalEnvio extends LGGModel {

    protected $table = 'sucursales_envios';
    public $timestamps = true;

    protected $fillable = ['sucursal_origen_id', 'sucursal_destino_id', 'genera_costo', 'dias_max_envio'];
    public static $rules = [
        'sucursal_origen_id'  => 'required|integer',
        'sucursal_destino_id' => 'required|integer',
        'genera_costo'        => 'required|boolean',
        'dias_max_envio'      => 'required|integer|between:0,99'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        SucursalEnvio::creating(function ($sucursal_envio) {
            if (!$sucursal_envio->isValid()) {
                return false;
            }

            return true;
        });
        SucursalEnvio::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });
    }

    /**
     * Obtiene la sucursal de origen a la cual está asociada el envío
     * @return App\Sucursal
     */
    public function sucursalOrigen() {
        return $this->belongsTo('App\Sucursal', 'sucursal_origen_id');
    }

    /**
     * Obtiene la sucursal destino a la cual está asociada el envío
     * @return App\Sucursal
     */
    public function sucursalDestino() {
        return $this->belongsTo('App\Sucursal', 'sucursal_destino_id');
    }
}
