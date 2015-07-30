<?php

namespace App;

class RmaDetalle extends LGGModel
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
        RmaDetalle::creating(function($model){
            if ( !$model->isValid() ){
                return false;
            }
            return true;
        });
    }
}
