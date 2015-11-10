<?php

namespace App;


/**
 * App\RazonSocialReceptor
 *
 * @property integer $id
 * @property string $rfc
 * @property string $regimen
 * @property integer $domicilio_id
 * @property integer $cliente_id
 * @property-read \App\Domicilio $domicilio
 * @property-read \App\Cliente $cliente
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Factura[] $facturas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\NotaCredito[] $notasCreditos
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialReceptor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialReceptor whereRfc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialReceptor whereRegimen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialReceptor whereDomicilioId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialReceptor whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\RazonSocialReceptor whereDeletedAt($value)
 */
class RazonSocialReceptor extends LGGModel {

    //
    protected $table = "razones_sociales_receptores";
    public $timestamps = false;
    protected $fillable = ['rfc', 'regimen', 'domicilio_id', 'cliente_id'];

    public static $rules = [
        'rfc'          => "min:13|max:13|regex:'[A-Z]{4}\d{6}[A-Z]\d{2}'",
        'regimen'      => 'max:60',
        'domicilio_id' => 'required|integer',
        'cliente_id'   => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        RazonSocialReceptor::creating(function ($model) {
            return $model->isValid();
        });
        RazonSocialReceptor::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene el Domicilio asociado con la Razon Social
     * @return App\Domicilio
     */
    public function domicilio() {
        return $this->belongsTo('App\Domicilio', 'domicilio_id');
    }


    /**
     * Obtiene el Cliente asociado con la Razon Social
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }


    /**
     * Obtiene las Facturas asociadas con la Razon Social Receptora
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function facturas() {
        return $this->hasMany('App\Factura', 'razon_social_receptor_id');
    }


    /**
     * Obtiene las Notas de Creditos asociadas con la Razon Social Receptora
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function notasCreditos() {
        return $this->hasMany('App\NotaCredito', 'razon_social_receptor_id');
    }
}
