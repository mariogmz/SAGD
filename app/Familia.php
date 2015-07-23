<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Familia extends Model
{
    //
    protected $table = "familias";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre', 'descripcion'];

    public static $rules = [
        'clave' => 'required|max:4',
        'nombre' => 'required|max:45',
        'descripcion' => 'max:100'
    ];

    /**
     * Define the model hooks
     */
    public static function boot() {
        Familia::creating(function($familia){
            $familia->clave = strtoupper($familia->clave);
            if ( !$familia->isValid() ){
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
