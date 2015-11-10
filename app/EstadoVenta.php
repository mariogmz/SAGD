<?php

namespace App;


/**
 * App\EstadoVenta
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Venta[] $ventas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaMovimiento[] $ventasMovimientos
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoVenta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoVenta whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoVenta whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoVenta whereDeletedAt($value)
 */
class EstadoVenta extends LGGModel {

    protected $table = "estados_ventas";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave'  => 'required|string|alpha|size:1|unique:estados_ventas',
        'nombre' => 'required|string|max:90'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoVenta::creating(function ($model) {
            return $model->isValid();
        });
        EstadoVenta::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,' . $model->id;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene las ventas con el estado relacionado
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

