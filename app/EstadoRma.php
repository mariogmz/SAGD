<?php

namespace App;


/**
 * App\EstadoRma
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Rma[] $rmas
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoRma whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoRma whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoRma whereDeletedAt($value)
 */
class EstadoRma extends LGGModel {

    protected $table = "estados_rmas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|string|max:80|unique:estados_rmas'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoRma::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        EstadoRma::updating(function ($estado_rma) {
            $estado_rma->updateRules = self::$rules;
            $estado_rma->updateRules['nombre'] .= ',nombre,' . $estado_rma->id;

            return $estado_rma->isValid('update');
        });
    }

    /**
     * Obtiene todos los rmas que tienen asociado el estado_rma
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rmas() {
        return $this->hasMany('App\Rma');
    }
}
