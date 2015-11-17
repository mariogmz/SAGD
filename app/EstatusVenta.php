<?php

namespace App;


/**
 * App\EstatusVenta
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Venta[] $ventas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaMovimiento[] $ventasMovimientos
 * @method static \Illuminate\Database\Query\Builder|\App\EstatusVenta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstatusVenta whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstatusVenta whereDeletedAt($value)
 */
class EstatusVenta extends LGGModel {

    protected $table = "estatus_ventas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:60'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstatusVenta::creating(function ($model) {
            return $model->isValid();
        });
        EstatusVenta::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene las ventas asociadas a este estatus
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventas() {
        return $this->hasMany('App\Venta');
    }

    /**
     * Obtiene los movimientos de venta asociados con el estado de venta
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasMovimientos() {
        return $this->hasMany('App\VentaMovimiento');
    }


}
