<?php

namespace App;


/**
 * App\Domicilio
 *
 * @property integer $id
 * @property string $calle
 * @property string $localidad
 * @property integer $codigo_postal_id
 * @property-read \App\CodigoPostal $codigoPostal
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Telefono[] $telefonos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sucursal[] $sucursales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Cliente[] $clientes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialEmisor[] $razonesSocialesEmisores
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RazonSocialReceptor[] $razonesSocialesReceptores
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereCalle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereLocalidad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereCodigoPostalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Domicilio whereDeletedAt($value)
 */
class Domicilio extends LGGModel {

    protected $table = 'domicilios';
    public $timestamps = false;

    protected $fillable = ['calle', 'localidad', 'codigo_postal_id', 'telefono_id'];
    public static $rules = [
        'calle'            => 'required|string|max:100',
        'localidad'        => 'required|string|max:50',
        'codigo_postal_id' => 'required|integer',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Domicilio::creating(function ($domicilio) {
            if (!$domicilio->isValid()) {
                return false;
            }

            return true;
        });
        Domicilio::updating(function ($domicilio) {
            $domicilio->updateRules = self::$rules;

            return $domicilio->isValid();
        });
    }

    /**
     * Obtiene el código postal asociado al domicilio
     * @return App\CodigoPostal
     */
    public function codigoPostal() {
        return $this->belongsTo('App\CodigoPostal');
    }

    /**
     * Obtiene el teléfono asociado al domicilio
     * @return App\Telefonos
     */
    public function telefonos() {
        return $this->hasMany('App\Telefono');
    }

    /**
     * Obtiene las sucursales asociadas al domicilio
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function sucursales() {
        return $this->hasMany('App\Sucursal');
    }


    /**
     * Obtiene los Clientes asociados con el Domicilio
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function clientes() {
        return $this->belongsToMany('App\Cliente', 'domicilios_clientes',
            'domicilio_id', 'cliente_id');
    }


    /**
     * Obtiene las Razones Sociales Emisores asociadas con el Domicilio
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function razonesSocialesEmisores() {
        return $this->hasMany('App\RazonSocialEmisor', 'domicilio_id');
    }


    /**
     * Obtiene las Razones Sociales Receptores asociadas con el Domicilio
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function razonesSocialesReceptores() {
        return $this->hasMany('App\RazonSocialReceptor', 'domicilio_id');
    }
}
