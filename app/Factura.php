<?php

namespace App;

class Factura extends LGGModel
{
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
        'folio' => 'required|max:45',
        'fecha_expedicion' => 'date',
        'fecha_timbrado' => 'date',
        'cadena_original_emisor' => 'required',
        'cadena_original_receptor' => 'required',
        'error_sat' => 'required|boolean',
        'forma_pago' => 'required|max:60',
        'metodo_pago' => 'required|max:60',
        'numero_cuenta_pago' => 'required|max:60',
        'lugar_expedicion' => 'required|max:45',
        'sello_digital_emisor' => 'required',
        'sello_digital_sat' => 'required',
        'xml' => 'required',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Factura::creating(function($model){
            return $model->isValid();
        });
        Factura::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Emisor asociado con la Factura
    * @return App\RazonSocialEmisor
    */
    public function razonSocialEmisor()
    {
        return $this->belongsTo('App\RazonSocialEmisor', 'razon_social_emisor_id');
    }


    /**
    * Obtiene el Receptor asociado con la Factura
    * @return App\RazonSocialReceptor
    */
    public function razonSocialReceptor()
    {
        return $this->belongsTo('App\RazonSocialReceptor', 'razon_social_receptor_id');
    }


    /**
    * Obtiene el Estado asociado con la factura
    * @return App\EstadoFactura
    */
    public function estado()
    {
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
