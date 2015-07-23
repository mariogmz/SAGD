<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Marca extends Model
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

    /**
     * This method is responsible for validating the model
     *
     * @return bool
     */
    public function isValid()
    {
        $validation = Validator::make($this->attributes, static ::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();
        return false;
    }
}
