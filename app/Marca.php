<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Marca extends LGGModel
{
    protected $table = 'marcas';

    public $timestamps = false;

    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => ['required','max:3','alpha','regex:/[A-Z]{3}/'],
        'nombre' => 'required|max:25'
    ];

    /**
     * Define the model hooks
     */
    public static function boot() {
        Marca::creating(function($marca){
            $marca->clave = strtoupper($marca->clave);
            if ( !$marca->isValid() ){
                return false;
            }
            return true;
        });
    }

}
