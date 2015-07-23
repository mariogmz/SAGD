<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Unidad extends Model
{
    //
    protected $table = "unidades";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => ['required','max:4','alpha','regex:/[A-Z]{4}/'],
        'nombre' => 'required|max:45'
    ];

    /**
     * Define the model hooks
     */
    public static function boot() {
        Unidad::creating(function($unidad){
            $unidad->clave = strtoupper($unidad->clave);
            if ( !$unidad->isValid() ){
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
