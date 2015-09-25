<?php

namespace App;


/**
 * App\ServicioSoporte
 *
 * @property integer $id
 * @property string $descripcion_equipo
 * @property string $falla
 * @property string $solucion
 * @property float $costo
 * @property string $fecha_recepcion
 * @property string $fecha_entrega
 * @property integer $estado_soporte_id
 * @property integer $empleado_id
 * @property integer $cliente_id
 * @property-read \App\EstadoSoporte $estadoSoporte
 * @property-read \App\Empleado $empleado
 * @property-read \App\Cliente $cliente
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SoporteProducto[] $soportesProductos
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereDescripcionEquipo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereFalla($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereSolucion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereCosto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereFechaRecepcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereFechaEntrega($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereEstadoSoporteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereEmpleadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ServicioSoporte whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class ServicioSoporte extends LGGModel {

    protected $table = "servicio_soporte";
    public $timestamps = false;
    protected $fillable = ['descripcion_equipo', 'falla', 'solucion', 'costo', 'fecha_recepcion', 'fecha_entrega', 'estado_soporte_id', 'empleado_id', 'cliente_id'];

    public static $rules = [
        'descripcion_equipo' => 'required|string|max:100',
        'falla'              => 'required|string|max:100',
        'solucion'           => 'string|max:100',
        'costo'              => 'required|numeric',
        'fecha_recepcion'    => 'required|date',
        'fecha_entrega'      => "date",
        'estado_soporte_id'  => 'required|integer',
        'empleado_id'        => 'required|integer',
        'cliente_id'         => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        ServicioSoporte::creating(function ($model) {
            if (!$model->isValid()) {
                return false;
            }

            return true;
        });
        ServicioSoporte::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });


    }

    /**
     * Obtiene el estado del soporte
     * @return App\EstadoSoporte
     */
    public function estadoSoporte() {
        return $this->belongsTo('App\EstadoSoporte');
    }

    /**
     * Obtiene el empleado que tiene asignado el soporte
     * @return App\Empleado
     */
    public function empleado() {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene el cliente al cual se le está dando el soporte
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtiene los soportes de producto que se asociaron con este soporte
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function soportesProductos() {
        return $this->hasMany('App\SoporteProducto');
    }
}
