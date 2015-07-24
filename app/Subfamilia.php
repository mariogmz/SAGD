<?php

namespace App;

class Subfamilia extends LGGModel
{
    //
    protected $table = "subfamilias";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => 'required|max:4',
        'nombre' => 'required|max:45',
        'familia_id' => 'required',
        'margen_id' => 'required'
    ];

    /**
     * Define the model hooks
     */
    public static function boot(){
        Subfamilia::creating(function($subfamilia){
            $subfamilia->clave = strtoupper($subfamilia->clave);
            if ( !$subfamilia->isValid() ){
                return false;
            }
            return true;
        });
    }

    public function familia()
    {
        return $this->belongsTo('App\Familia');
    }

    public function margen()
    {
        return $this->belongsTo('App\Margen');
    }
}
