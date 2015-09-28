<?php

namespace App;


/**
 * App\Garantia
 *
 * @property integer $id
 * @property string $serie
 * @property integer $venta_detalle_id
 * @property-read \App\VentaDetalle $ventaDetalle
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RmaDetalle[] $rmasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reposicion[] $reposiciones
 * @method static \Illuminate\Database\Query\Builder|\App\Garantia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Garantia whereSerie($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Garantia whereVentaDetalleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Garantia extends LGGModel {

    protected $table = "garantias";
    public $timestamps = false;
    protected $fillable = ['serie', 'venta_detalle_id'];

    public static $rules = [
        'serie'            => 'required|string|max:45',
        'venta_detalle_id' => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Garantia::creating(function ($model) {
            return $model->isValid();
        });
        Garantia::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el detalle de la venta asociado con esta garantia
     * @return App\VentaDetalle
     */
    public function ventaDetalle() {
        return $this->belongsTo('App\VentaDetalle');
    }

    /**
     * Obtiene los detalles de RMA que están asociados con esta garantía
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmasDetalles() {
        return $this->hasMany('App\RmaDetalle');
    }

    /**
     * Obtiene las reposiciones realizadas asociadas a esta garantía
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reposiciones() {
        return $this->hasMany('App\Reposicion');
    }


}
