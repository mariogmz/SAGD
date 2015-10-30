<?php

namespace App;


/**
 * App\Rol
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @method static \Illuminate\Database\Query\Builder|\App\Rol whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rol whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Rol whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Rol extends LGGModel {

    //
    protected $table = "roles";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave'  => 'required|max:6',
        'nombre' => 'required|max:45'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Rol::creating(function ($rol) {
            $rol->clave = strtoupper($rol->clave);
            if (!$rol->isValid()) {
                return false;
            }

            return true;
        });
        Rol::updating(function ($rol) {
            $rol->clave = strtoupper($rol->clave);
            $rol->updateRules = self::$rules;

            return $rol->isValid('update');
        });
    }


    /**
     * Agrega los Permisos al Rol
     * @param array|App\Permiso $permisos
     * @return void
     */
    public function agregarPermisos(array $permisos)
    {
        foreach ($permisos as $permiso) {
            $this->permisos()->attach($permiso->id);
        }
    }

    /**
     * Agrega los Permisos al Rol
     * @param array|App\Permiso $permisos
     * @return void
     */
    public function quitarPermisos(array $permisos)
    {
        foreach ($permisos as $permiso) {
            $this->permisos()->detach($permiso->id);
        }
    }

    /**
    * Obtiene los Empleados asociados con el Rol
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function empleados()
    {
        return $this->belongsToMany('App\Empleado', 'empleados_roles', 'rol_id', 'empleado_id')
            ->withTimestamps();
    }


    /**
    * Obtiene los Permisos asociados con el Rol
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function permisos()
    {
        return $this->belongsToMany('App\Permiso', 'roles_permisos', 'rol_id', 'permiso_id');
    }
}
