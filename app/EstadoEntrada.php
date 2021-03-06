<?php

namespace App;


/**
 * App\EstadoEntrada
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entrada[] $entradas
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoEntrada whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoEntrada whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoEntrada whereDeletedAt($value)
 */
class EstadoEntrada extends LGGModel {

    //
    protected $table = "estados_entradas";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45|unique:estados_entradas',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoEntrada::creating(function ($ee) {
            return $ee->isValid();
        });
        EstadoEntrada::updating(function ($ee) {
            $ee->updateRules = self::$rules;
            $ee->updateRules['nombre'] .= ',nombre,' . $ee->id;

            return $ee->isValid('update');
        });
    }


    /**
     * Obtiene la relacion del Estado de Cargado
     * @return App\EstadoEntrada
     */
    public static function creando() {
        return EstadoEntrada::where('nombre', 'Creando')->first();
    }

    /**
     * Obtiene la relacion del Estado de Cargando
     * @return App\EstadoEntrada
     */
    public static function cargando() {
        return EstadoEntrada::where('nombre', 'Cargando')->first();
    }

    /**
     * Obtiene la relacion del Estado de Cargado
     * @return App\EstadoEntrada
     */
    public static function cargado() {
        return EstadoEntrada::where('nombre', 'Cargado')->first();
    }

    /**
     * Obtiene las Entradas asociadas con el Estatus
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradas() {
        return $this->hasMany('App\Entrada', 'estado_entrada_id');
    }
}
