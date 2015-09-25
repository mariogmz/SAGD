<?php

namespace App;


/**
 * App\RmaTiempo
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @method static \Illuminate\Database\Query\Builder|\App\RmaTiempo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\RmaTiempo whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class RmaTiempo extends LGGModel {

    protected $table = "rmas_tiempos";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:45|unique:rmas_tiempos'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        RmaTiempo::creating(function ($model) {
            return $model->isValid();
        });
        RmaTiempo::updating(function ($rmat) {
            $rmat->updateRules = self::$rules;
            $rmat->updateRules['nombre'] .= ',nombre,' . $rmat->id;

            return $rmat->isValid('update');
        });
    }

    /**
     * Obtiene los rmas asociados con el tiempo de rma
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas() {
        return $this->hasMany('App\Rma');
    }
}
