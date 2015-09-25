<?php

namespace App;


/**
 * App\MetodoPago
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property float $comision
 * @property float $monto_minimo
 * @property string $informacion_adicional
 * @property integer $estatus_activo_id
 * @property-read \App\EstatusActivo $estatusActivo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MetodoPagoRango[] $metodosPagosRangos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaDetalle[] $ventasDetalles
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereComision($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereMontoMinimo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereInformacionAdicional($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MetodoPago whereEstatusActivoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class MetodoPago extends LGGModel {

    protected $table = "metodos_pagos";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre', 'comision', 'monto_minimo', 'informacion_adicional', 'estatus_activo_id'];

    public static $rules = [
        'clave'                 => 'required|string|max:10|unique:metodos_pagos',
        'nombre'                => 'string|max:90',
        'comision'              => 'required|numeric',
        'monto_minimo'          => 'required|numeric',
        'informacion_adicional' => 'string|max:100',
        'estatus_activo_id'     => 'required|integer'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        MetodoPago::creating(function ($model) {
            return $model->isValid();
        });
        MetodoPago::updating(function ($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['clave'] .= ',clave,' . $model->id;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el estatus asociado a la forma de pago
     * @return App\EstatusActivo
     */
    public function estatusActivo() {
        return $this->belongsTo('App\EstatusActivo', 'estatus_activo_id');
    }

    /**
     * Obtiene los rangos para este método de pago
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function metodosPagosRangos() {
        return $this->hasMany('App\MetodoPagoRango');
    }

    /**
     * Obtiene los detalles de venta relacionados con el método de pago
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasDetalles() {
        return $this->hasMany('App\VentaDetalle');
    }

}
