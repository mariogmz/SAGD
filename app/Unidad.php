<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Unidad extends LGGModel
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
     * @codeCoverageIgnore
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
     * Get the associated productos with unidad
     * @return array
     */
    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
}
