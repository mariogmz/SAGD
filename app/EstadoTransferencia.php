<?php

namespace App;


/**
 * Definicion de estados:
 * 1 => Abierta.                    Puede editarse y cargarse
 * 2 => Cargando Local.             En proceso de carga, no puede editarse
 * 3 => Cargada Local.              La carga se realizo con exito, no puede editarse
 * 4 => Iniciando Transferencia.
 * 
 * 5 => Transferencia Terminada.    Lista Para Cargarse Sucursal Destino
 * 6 => Cargando Otra Sucursal.     En proceso de carga en otra sucursal
 * 7 => Cargada Otra Sucursal.      Indica que se realizo la carga exitosamente
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transferencia[] $transferencias
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoTransferencia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoTransferencia whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\EstadoTransferencia whereDeletedAt($value)
 */

class EstadoTransferencia extends LGGModel {

    //
    protected $table = "estados_transferencias";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        EstadoTransferencia::creating(function ($model) {
            return $model->isValid();
        });
        EstadoTransferencia::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }

    /**
     * Obtiene el estado transferencia de abiera
     */
    public static function abierta()
    {
        return EstadoTransferencia::where('nombre', 'Abierta')->last()->id;
    }

    /**
     * Obtiene el estado transferencia de cargando origen
     */
    public static function cargandoOrigen()
    {
        return EstadoTransferencia::where('nombre', 'Cargando Origen')->last()->id;
    }

    /**
     * Obtiene el estado transferencia de en transferencia
     */
    public static function enTransferencia()
    {
        return EstadoTransferencia::where('nombre', 'En transferencia')->last()->id;
    }

    /**
     * Obtiene el estado transferencia de cargando destino
     */
    public static function cargandoDestino()
    {
        return EstadoTransferencia::where('nombre', 'Cargando Destino')->last()->id;
    }

    /**
     * Obtiene el estado transferencia de finalizada
     */
    public static function finalizada()
    {
        return EstadoTransferencia::where('nombre', 'Finalizada')->last()->id;
    }

    /**
     * Obtiene las Transferencias asociadas con el Estado
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function transferencias() {
        return $this->hasMany('App\Transferencia', 'estado_transferencia_id');
    }
}
