<?php

namespace App;

class EstadoFactura extends LGGModel
{
    //
    protected $table = "estados_facturas";
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
    public static function boot(){
        EstadoFactura::creating(function($model){
            return $model->isValid();
        });
        EstadoFactura::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene las Facturas asociadas con el Estado
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function facturas()
    {
        return $this->hasMany('App\Factura', 'factura_status_id');
    }
}
