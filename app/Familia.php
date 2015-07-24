<?php

namespace App;

class Familia extends LGGModel
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

    public function subfamilias()
    {
        return $this->hasMany('App\Subfamilia');
    }
}
