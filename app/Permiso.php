<?php

namespace App;


/**
 * App\Permiso
 *
 * @property integer $id
 * @property string $controlador
 * @property string $accion
 * @method static \Illuminate\Database\Query\Builder|\App\Permiso whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permiso whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permiso whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Permiso extends LGGModel
{
    protected $table = "permisos";
    public $timestamps = false;
    protected $fillable = ['controlador', 'accion', 'descripcion'];

    public static $rules = [
        'controlador'   => 'required|max:45|unique_with:permisos,accion',
        'accion'        => 'required|max:45',
        'descripcion'   => 'required|max:140',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Permiso::creating(function ($model) {
            return $model->isValid();
        });
        Permiso::updating(function($model) {
            $model->updateRules = self::$rules;
            $model->updateRules['controlador'] .= ',controlador,' . $model->id;

            return $model->isValid('update');
        });
    }

    /**
    * Obtiene los Roles asociados con el Permiso
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function roles()
    {
        return $this->belongsToMany('App\Rol', 'roles_permisos', 'permiso_id', 'rol_id');
    }

    /**
     * Obtiene los Permisos donde sus Roles no sean los individuales
     */
    public static function permisosRoles()
    {
        return Rol::whereIndividual(false)->with('permisos')->get();
    }
}
