<?php

namespace App;


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

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        ServicioSoporte::creating(function ($model)
        {
            if (!$model->isValid())
            {
                return false;
            }

            return true;
        });


    }

    /**
     * Obtiene el estado del soporte
     * @return App\EstadoSoporte
     */
    public function estadoSoporte()
    {
        return $this->belongsTo('App\EstadoSoporte');
    }

    /**
     * Obtiene el empleado que tiene asignado el soporte
     * @return App\Empleado
     */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

    /**
     * Obtiene el cliente al cual se le está dando el soporte
     * @return App\Cliente
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }
}
