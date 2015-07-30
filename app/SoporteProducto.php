<?php

namespace App;

class SoporteProducto extends LGGModel
{
    //
    protected $table = "";
    public $timestamps = false;
    protected $fillable = [];

    public static $rules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        SoporteProducto::creating(function($model){
            if ( !$model->isValid() ){
                return false;
            }
            return true;
        });
    }
}
