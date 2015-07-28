<?php

namespace App;


class Domicilio extends LGGModel {

    protected $table = 'domicilios';
    public $timestamps = false;

    protected $fillable = ['calle', 'localidad', 'codigo_postal_id', 'telefono_id'];
    public static $rules = [
        'calle'            => 'required|string|max:45',
        'localidad'        => 'required|string|max:45',
        'codigo_postal_id' => 'required|integer',
        'telefono_id'      => 'required|integer'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        DatoContacto::creating(function ($domicilio)
        {
            if (!$domicilio->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene el código postal asociado al domicilio
     * @return App\CodigoPostal
     */
    public function codigoPostal()
    {
        return $this->belongsTo('App\CodigoPostal');
    }

    /**
     * Obtiene el teléfono asociado al domicilio
     * @return App\Telefono
     */
    public function telefono()
    {
        return $this->belongsTo('App\Telefono');
    }

    /**
     * Obtiene las sucursales asociadas al domicilio
     * @return array
     */
    public function sucursales()
    {
        return $this->hasMany('App\Sucursal');
    }

}
