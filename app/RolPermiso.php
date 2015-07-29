<?php

namespace App;

class RolPermiso extends LGGModel
{
    //
    protected $table = "roles_permisos";
    public $timestamps = false;
    protected $fillable = [];

    public static $rules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        RolPermiso::creating(function($rp){
            if ( !$rp->isValid() ){
                return false;
            }
            return true;
        });
    }
}
