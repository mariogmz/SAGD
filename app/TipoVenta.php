<?php

namespace App;


/**
 * App\TipoVenta
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Venta[] $ventas
 * @method static \Illuminate\Database\Query\Builder|\App\TipoVenta whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoVenta whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\TipoVenta whereDeletedAt($value)
 */
class TipoVenta extends LGGModel {

    protected $table = "tipos_ventas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = ['nombre' => 'required|string|max:60'];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        TipoVenta::creating(function ($model) {
            return $model->isValid();
        });
        TipoVenta::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene las ventas con este tipo
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventas() {
        return $this->hasMany('App\Venta');
    }

}
