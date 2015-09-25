<?php

namespace App;


/**
 * App\NivelPermiso
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $nivel
 * @method static \Illuminate\Database\Query\Builder|\App\NivelPermiso whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NivelPermiso whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\NivelPermiso whereNivel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class NivelPermiso extends LGGModel {

    //
    protected $table = "niveles_permisos";
    public $timestamps = false;
    protected $fillable = ['nombre', 'nivel'];

    public static $rules = [
        'nombre' => 'required|max:45',
        'nivel'  => 'required|integer|min:0',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        NivelPermiso::creating(function ($model) {
            return $model->isValid();
        });
        NivelPermiso::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }
}
