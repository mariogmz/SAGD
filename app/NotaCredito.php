<?php

namespace App;


/**
 * App\NotaCredito
 *
 * @property integer $id
 * @property string $folio
 * @property string $fecha_expedicion
 * @property string $fecha_timbrado
 * @property string $cadena_original_emisor
 * @property string $cadena_original_receptor
 * @property boolean $error_sat
 * @property string $forma_pago
 * @property string $metodo_pago
 * @property string $numero_cuenta_pago
 * @property string $sello_digital_emisor
 * @property string $sello_digital_sat
 * @property string $xml
 * @property string $lugar_expedicion
 * @property integer $razon_social_emisor_id
 * @property integer $razon_social_receptor_id
 * @property integer $factura_status_id
 * @property-read \App\RazonSocialEmisor $razonSocialEmisor
 * @property-read \App\RazonSocialReceptor $razonSocialReceptor
 * @property-read \App\EstadoFactura $estado
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\VentaDetalle[] $ventasDetalles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereFolio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereFechaExpedicion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereFechaTimbrado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereCadenaOriginalEmisor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereCadenaOriginalReceptor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereErrorSat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereFormaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereMetodoPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereNumeroCuentaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereSelloDigitalEmisor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereSelloDigitalSat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereXml($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereLugarExpedicion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereRazonSocialEmisorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereRazonSocialReceptorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NotaCredito whereFacturaStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class NotaCredito extends LGGModel {

    //
    protected $table = "notas_creditos";
    public $timestamps = false;
    protected $fillable = ['folio', 'fecha_expedicion', 'fecha_timbrado',
        'cadena_original_emisor', 'cadena_original_receptor', 'error_sat',
        'forma_pago', 'metodo_pago', 'numero_cuenta_pago', 'sello_digital_emisor',
        'sello_digital_sat', 'xml', 'lugar_expedicion', 'razon_social_emisor_id',
        'razon_social_receptor_id', 'factura_status_id'
    ];

    public static $rules = [
        'folio'                    => 'required|max:45',
        'fecha_expedicion'         => 'date',
        'fecha_timbrado'           => 'date',
        'cadena_original_emisor'   => 'required',
        'cadena_original_receptor' => 'required',
        'error_sat'                => 'required|boolean',
        'forma_pago'               => 'required|max:60',
        'metodo_pago'              => 'required|max:60',
        'numero_cuenta_pago'       => 'required|max:60',
        'lugar_expedicion'         => 'required|max:45',
        'sello_digital_emisor'     => 'required',
        'sello_digital_sat'        => 'required',
        'xml'                      => 'required',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        NotaCredito::creating(function ($model) {
            return $model->isValid();
        });
        NotaCredito::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Emisor asociado con la nota de crédito
     * @return App\RazonSocialEmisor
     */
    public function razonSocialEmisor() {
        return $this->belongsTo('App\RazonSocialEmisor', 'razon_social_emisor_id');
    }


    /**
     * Obtiene el Receptor asociado con la nota de crédito
     * @return App\RazonSocialReceptor
     */
    public function razonSocialReceptor() {
        return $this->belongsTo('App\RazonSocialReceptor', 'razon_social_receptor_id');
    }


    /**
     * Obtiene el Estado asociado con la nota de crédito
     * @return App\EstadoFactura
     */
    public function estado() {
        return $this->belongsTo('App\EstadoFactura', 'factura_status_id');
    }

    /**
     * Obtiene los detalles de venta incluidos en la nota de crédito
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasDetalles() {
        return $this->hasMany('App\VentaDetalle');
    }

    /**
     * Obtiene los RMAs asociados con la nota de crédito
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas() {
        return $this->hasMany('App\Rma');
    }

}
