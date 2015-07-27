<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class CodigoPostal extends LGGModel {

    protected $table = 'codigos_postales';
    public $timestamps = false;

    protected $fillable = ['estado', 'municipio', 'codigo_postal'];
    public static $rules = [
        'estado'        => 'required|string|max:45|alpha',
        'municipio'     => 'required|string|max:45|alpha',
        'codigo_postal' => ['required','unique:codigos_postales','Regex:/[0-9]{5}/']
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        DatoContacto::creating(function ($codigo_postal)
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
}
