<?php

namespace App;


/**
 * App\EstadoSalida
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Salida[] $salidas
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSalida whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSalida whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoSalida whereDeletedAt($value)
 */
class EstadoSalida extends LGGModel {

    //
    protected $table = "estados_salidas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45|unique:estados_salidas',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoSalida::creating(function ($es) {
            return $es->isValid();
        });
        EstadoSalida::updating(function ($es) {
            $es->updateRules = self::$rules;
            $es->updateRules['nombre'] .= ',nombre,' . $es->id;

            return $es->isValid('update');
        });
    }

    /**
     * Obtiene la relacion del Estado de Cargado
     * @return App\EstadoSalida
     */
    public static function creando() {
        return EstadoSalida::where('nombre', 'Creando')->first();
    }

    /**
     * Obtiene la relacion del Estado de Cargando
     * @return App\EstadoSalida
     */
    public static function cargando() {
        return EstadoSalida::where('nombre', 'Cargando')->first();
    }

    /**
     * Obtiene la relacion del Estado de Cargado
     * @return App\EstadoSalida
     */
    public static function cargado() {
        return EstadoSalida::where('nombre', 'Cargado')->first();
    }

    /**
     * Obtiene las Salidas asociadas con el Estado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function salidas() {
        return $this->hasMany('App\Salida', 'estado_salida_id');
    }
}
