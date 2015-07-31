<?php

namespace App;

class Entrada extends LGGModel
{
    //
    protected $table = "entradas";
    public $timestamps = true;
    protected $fillable = ['factura_externa_numero', 'factura_fecha', 'moneda', 'tipo_cambio'];

    public static $rules = [
        'factura_externa_numero' => 'required|max:45',
        'factura_fecha' => 'date',
        'moneda' => 'required|max:45',
        'tipo_cambio' => 'required|numeric',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Entrada::creating(function($model){
            return $model->isValid();
        });
        Entrada::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene el Estado asociado con la Entrada
    * @return App\Estado
    */
    public function estado()
    {
        return $this->belongsTo('App\EstadoEntrada', 'estado_entrada_id');
    }


    /**
    * Obtiene el Proveedor asociado con la Entrada
    * @return App\Proveedor
    */
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor', 'proveedor_id');
    }


    /**
    * Obtiene la Razon Social asociada con la Entrada
    * @return App\RazonSocialEmisor
    */
    public function razonSocial()
    {
        return $this->belongsTo('App\RazonSocialEmisor', 'razon_social_id');
    }


    /**
    * Obtiene el Empleado asociado con la Entrada
    * @return App\Empleado
    */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }


    /**
    * Obtiene los Detalles asociados con la Entrada
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function detalles()
    {
        return $this->hasMany('App\EntradaDetalle', 'entrada_id');
    }
}
