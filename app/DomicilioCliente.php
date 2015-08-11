<?php

namespace App;

class DomicilioCliente extends LGGModel
{
    //
    protected $table = "domicilios_clientes";
    public $timestamps = false;
    protected $fillable = [];

    public static $rules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        DomicilioCliente::creating(function($model){
            if ( !$model->isValid() ){
                return false;
            }
            return true;
        });
    }
}
