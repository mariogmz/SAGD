<?php

namespace App;


/**
 * App\RolPermiso
 *
 * @property integer $id
 * @property integer $rol_id
 * @method static \Illuminate\Database\Query\Builder|\App\RolPermiso whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RolPermiso whereRolId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class RolPermiso extends LGGModel {

    //
    protected $table = "roles_permisos";
    public $timestamps = false;
    protected $fillable = [];

    public static $rules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        RolPermiso::creating(function ($rp) {
            if (!$rp->isValid()) {
                return false;
            }

            return true;
        });
    }
}
