<?php

namespace App;

class ClienteReferencia extends LGGModel
{
    //
    protected $table = "clientes_referencias";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:50'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ClienteReferencia::creating(function($cr){
            if ( !$cr->isValid() ){
                return false;
            }
            return true;
        });
    }
}
