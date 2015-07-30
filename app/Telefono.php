<?php

namespace App;


class Telefono extends LGGModel {

    protected $table = 'telefonos';
    public $timestamps = false;

    protected $fillable = ['numero', 'tipo'];
    public static $rules = [
        'numero' => ['required', 'unique:telefonos', 'regex:/[0-9]{7,11}/'],
        'tipo'   => 'required|max:45'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        Telefono::creating(function ($telefono)
        {
            if (!$telefono->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene los domicilios asociados con el teléfono
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function domicilios()
    {
        return $this->hasMany('App\Domicilio');
    }

}
