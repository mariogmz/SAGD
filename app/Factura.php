<?php

namespace App;


/**
 * App\Factura
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
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereFolio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereFechaExpedicion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereFechaTimbrado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereCadenaOriginalEmisor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereCadenaOriginalReceptor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereErrorSat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereFormaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereMetodoPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereNumeroCuentaPago($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereSelloDigitalEmisor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereSelloDigitalSat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereXml($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereLugarExpedicion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereRazonSocialEmisorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereRazonSocialReceptorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factura whereFacturaStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Factura extends LGGModel {

    //
    protected $table = "facturas";
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
        parent::boot();
        Factura::creating(function ($model) {
            return $model->isValid();
        });
        Factura::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Emisor asociado con la Factura
     * @return App\RazonSocialEmisor
     */
    public function razonSocialEmisor() {
        return $this->belongsTo('App\RazonSocialEmisor', 'razon_social_emisor_id');
    }


    /**
     * Obtiene el Receptor asociado con la Factura
     * @return App\RazonSocialReceptor
     */
    public function razonSocialReceptor() {
        return $this->belongsTo('App\RazonSocialReceptor', 'razon_social_receptor_id');
    }


    /**
     * Obtiene el Estado asociado con la factura
     * @return App\EstadoFactura
     */
    public function estado() {
        return $this->belongsTo('App\EstadoFactura', 'factura_status_id');
    }

    /**
     * Obtiene los detalles de venta incluidos en esta factura
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function ventasDetalles() {
        return $this->hasMany('App\VentaDetalle');
    }

}
