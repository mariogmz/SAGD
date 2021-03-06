<?php

namespace App;


/**
 * Definicion de estados:
 * 1 => Sin Apartar
 * 2 => Apartado
 * 3 => Desapartado
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Apartado[] $apartados
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoApartado whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoApartado whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoApartado whereDeletedAt($value)
 */

class EstadoApartado extends LGGModel {

    //
    protected $table = "estados_apartados";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoApartado::creating(function ($model) {
            return $model->isValid();
        });
        EstadoApartado::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene los Apartados asociados con el Estado Apartado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function apartados() {
        return $this->hasMany('App\Apartado', 'estado_apartado_id');
    }
}
