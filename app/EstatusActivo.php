<?php

namespace App;


/**
 * App\EstatusActivo
 *
 * @property integer $id
 * @property string $estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MetodoPago[] $metodosPagos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Guia[] $guias
 * @method static \Illuminate\Database\Query\Builder|\App\EstatusActivo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstatusActivo whereEstatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class EstatusActivo extends LGGModel {

    //
    protected $table = "estatus_activo";
    public $timestamps = false;
    protected $fillable = ['estatus'];

    public static $rules = [
        'estatus' => 'required|string|max:45'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstatusActivo::creating(function ($model) {
            return $model->isValid();
        });
        EstatusActivo::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene los métodos de pago con el estatus asociado
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function metodosPagos() {
        return $this->hasMany('App\MetodoPago', 'estatus_activo_id');
    }


    /**
     * Obtiene las Guias asociadas con el Estatus Activo
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function guias() {
        return $this->hasMany('App\Guia', 'estatus_activo_id');
    }
}
