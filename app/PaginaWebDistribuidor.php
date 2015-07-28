<?php

namespace App;

class PaginaWebDistribuidor extends LGGModel
{
    //
    protected $table = "paginas_web_distribuidores";
    public $timestamps = false;
    protected $fillable = ['activo', 'fecha_vencimiento', 'url'];

    public static $rules = [
        'activo' => 'required|boolean',
        'fecha_vencimiento' => 'required|date',
        'url' => 'max:100'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        PaginaWebDistribuidor::creating(function($pwd){
            if ( !$pwd->isValid() ){
                return false;
            }
            return true;
        });
    }
}
