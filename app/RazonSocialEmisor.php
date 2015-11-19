<?php

namespace App;


/**
 * App\RazonSocialEmisor
 *
 * @property integer $id
 * @property string $rfc
 * @property string $razon_social
 * @property string $serie
 * @property integer $ultimo_folio
 * @property integer $numero_certificado
 * @property integer $numero_certificado_sat
 * @property integer $domicilio_id
 * @property integer $sucursal_id
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\Domicilio $domicilio
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entrada[] $entradas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Factura[] $facturas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\NotaCredito[] $notasCreditos
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereRfc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereRazonSocial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereSerie($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereUltimoFolio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereNumeroCertificado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereNumeroCertificadoSat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereDomicilioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialEmisor whereDeletedAt($value)
 */
class RazonSocialEmisor extends LGGModel {

    //
    protected $table = "razones_sociales_emisores";
    public $timestamps = false;
    protected $fillable = ['sucursal_id', 'domicilio_id', 'rfc', 'razon_social', 'serie', 'ultimo_folio',
        'numero_certificado', 'numero_certificado_sat'];

    public static $rules = [
        'rfc'                    => "required|min:13|max:13|regex:'[A-Z]{4}\d{6}[A-Z]\d{2}'",
        'razon_social'                => 'required|max:60',
        'serie'                  => 'required|max:3',
        'ultimo_folio'           => 'required|integer',
        'numero_certificado'     => 'required|integer',
        'numero_certificado_sat' => 'required|integer'

    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        RazonSocialEmisor::creating(function ($model) {
            return $model->isValid();
        });
        RazonSocialEmisor::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene la Sucursal asociada con la Razon Social Emisora
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
     * Obtiene el Domicilio asociado con la Razon Social Emisora
     * @return App\Domicilio
     */
    public function domicilio() {
        return $this->belongsTo('App\Domicilio', 'domicilio_id');
    }


    /**
     * Obtiene las Entradas asociadas con la Razon Social Emisora
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradas() {
        return $this->hasMany('App\Entrada', 'razon_social_id');
    }


    /**
     * Obtiene las Facturas asociadas con la Razon Social Emisora
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function facturas() {
        return $this->hasMany('App\Factura', 'razon_social_emisor_id');
    }


    /**
     * Obtiene las Notas de Credito asociadas con la Razon Social Emisora
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function notasCreditos() {
        return $this->hasMany('App\NotaCredito', 'razon_social_emisor_id');
    }
}
