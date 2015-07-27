<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Telefono extends LGGModel {

    protected $table = 'telefonos';
    public $timestamps = false;

    protected $fillable = ['numero', 'tipo'];
    public static $rules = [
        'numero' => ['required','unique:telefonos','regex:/[0-9]{7,11}/'],
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

}
