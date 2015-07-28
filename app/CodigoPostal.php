<?php

namespace App;


class CodigoPostal extends LGGModel {

    protected $table = 'codigos_postales';
    public $timestamps = false;

    protected $fillable = ['estado', 'municipio', 'codigo_postal'];
    public static $rules = [
        'estado'        => 'required|string|max:45|alpha',
        'municipio'     => 'required|string|max:45|alpha',
        'codigo_postal' => ['required','string','unique:codigos_postales','regex:/(\d{5})/']
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        CodigoPostal::creating(function ($codigo_postal)
        {
            $codigo_postal->estado = strtoupper($codigo_postal->estado);
            $codigo_postal->municipio = strtoupper($codigo_postal->municipio);
            if (!$codigo_postal->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene los domicilios asociados al código postal
     * @return array
     */
    public function domicilios()
    {
        return $this->hasMany('App\Domicilio');
    }
}
