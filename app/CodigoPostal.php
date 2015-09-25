<?php

namespace App;


/**
 * App\CodigoPostal
 *
 * @property integer $id
 * @property string $estado
 * @property string $municipio
 * @property string $codigo_postal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domicilio[] $domicilios
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PaqueteriaCobertura[] $paqueteriaCoberturas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Paqueteria[] $paqueterias
 * @method static \Illuminate\Database\Query\Builder|\App\CodigoPostal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CodigoPostal whereEstado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CodigoPostal whereMunicipio($value)
 * @method static \Illuminate\Database\Query\Builder|\App\CodigoPostal whereCodigoPostal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class CodigoPostal extends LGGModel {

    protected $table = 'codigos_postales';
    public $timestamps = false;

    protected $fillable = ['estado', 'municipio', 'codigo_postal'];
    public static $rules = [
        'estado'        => 'required|string|max:45',
        'municipio'     => 'required|string|max:50',
        'codigo_postal' => ['required', 'string', 'unique:codigos_postales', 'regex:/(\d{5})/']
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        CodigoPostal::creating(function ($codigo_postal) {
            return $codigo_postal->isValid();
        });

        CodigoPostal::updating(function ($codigo_postal) {
            $codigo_postal->updateRules = self::$rules;
            $codigo_postal->updateRules['codigo_postal'] = [
                'required',
                'string',
                'unique:codigos_postales,codigo_postal,' . $codigo_postal->id,
                'regex:/(\d{5})/'
            ];

            return $codigo_postal->isValid('update');
        });
    }

    /**
     * Obtiene los domicilios asociados al código postal
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function domicilios() {
        return $this->hasMany('App\Domicilio');
    }


    /**
     * Obtiene las Paqueterias Coberturas asociadas con el Codigo Postal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function paqueteriaCoberturas() {
        return $this->hasMany('App\PaqueteriaCobertura', 'codigo_postal_id');
    }


    /**
     * Obtiene las Paqueterias asociadas con el Codigo Postal
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function paqueterias() {
        return $this->belongsToMany('App\Paqueteria', 'paqueterias_coberturas',
            'codigo_postal_id', 'paqueteria_id');
    }
}
