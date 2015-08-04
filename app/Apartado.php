<?php

namespace App;

class Apartado extends LGGModel
{
    //
    protected $table = "apartados";
    public $timestamps = true;
    protected $fillable = ['fecha_apartado', 'fecha_desapartado', 'concepto'];

    public static $rules = [
        'concepto' => 'required|max:255',
        'fecha_apartado' => 'date',
        'fecha_desapartado' => 'date'
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Apartado::creating(function($model){
            return $model->isValid();
        });
        Apartado::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Estado Apartado asociado con el Apartado
    * @return App\EstadoApartado
    */
    public function estado()
    {
        return $this->belongsTo('App\EstadoApartado', 'estado_apartado_id');
    }


    /**
    * Obtiene la Sucursal asociada con el Apartado
    * @return App\Sucursal
    */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal', 'sucursal_id');
    }


    /**
    * Obtiene el Empleado que Aparto asociado con el Apartado
    * @return App\Empleado
    */
    public function empleadoApartado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_apartado_id');
    }


    /**
    * Obtiene el Empleado que Desaparto asociado con el Apartado
    * @return App\Empleado
    */
    public function empleadoDesapartado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_desapartado_id');
    }


    /**
    * Obtiene el Apartado Detalle asociado con el Apartado
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function detalles()
    {
        return $this->hasMany('App\ApartadoDetalle', 'apartado_id');
    }
}
