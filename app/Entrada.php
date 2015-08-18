<?php

namespace App;


/**
 * App\Entrada
 *
 * @property integer $id
 * @property string $factura_externa_numero
 * @property string $factura_fecha
 * @property string $moneda
 * @property float $tipo_cambio
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $estado_entrada_id
 * @property integer $proveedor_id
 * @property integer $razon_social_id
 * @property integer $empleado_id
 * @property-read \App\EstadoEntrada $estado
 * @property-read \App\Proveedor $proveedor
 * @property-read \App\RazonSocialEmisor $razonSocial
 * @property-read \App\Empleado $empleado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\EntradaDetalle[] $detalles
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereFacturaExternaNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereFacturaFecha($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereMoneda($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereTipoCambio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereEstadoEntradaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereProveedorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereRazonSocialId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entrada whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Entrada extends LGGModel {

    //
    protected $table = "entradas";
    public $timestamps = true;
    protected $fillable = ['factura_externa_numero', 'factura_fecha', 'moneda', 'tipo_cambio',
        'estado_entrada_id', 'proveedor_id', 'razon_social_id', 'empleado_id'];

    public static $rules = [
        'factura_externa_numero' => 'required|max:45',
        'factura_fecha'          => 'date',
        'moneda'                 => 'required|max:45',
        'tipo_cambio'            => 'required|numeric',
        'estado_entrada_id'      => 'required|integer',
        'proveedor_id'           => 'required|integer',
        'razon_social_id'        => 'required|integer',
        'empleado_id'            => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Entrada::creating(function ($model) {
            return $model->isValid();
        });
        Entrada::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Estado asociado con la Entrada
     * @return App\Estado
     */
    public function estado() {
        return $this->belongsTo('App\EstadoEntrada', 'estado_entrada_id');
    }


    /**
     * Obtiene el Proveedor asociado con la Entrada
     * @return App\Proveedor
     */
    public function proveedor() {
        return $this->belongsTo('App\Proveedor', 'proveedor_id');
    }


    /**
     * Obtiene la Razon Social asociada con la Entrada
     * @return App\RazonSocialEmisor
     */
    public function razonSocial() {
        return $this->belongsTo('App\RazonSocialEmisor', 'razon_social_id');
    }


    /**
     * Obtiene el Empleado asociado con la Entrada
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }


    /**
     * Obtiene los Detalles asociados con la Entrada
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function detalles() {
        return $this->hasMany('App\EntradaDetalle', 'entrada_id');
    }
}
