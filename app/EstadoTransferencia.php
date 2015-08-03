<?php

namespace App;

class EstadoTransferencia extends LGGModel
{
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
    public static function boot(){
        EstadoTransferencia::creating(function($model){
            return $model->isValid();
        });
        EstadoTransferencia::updating(function($model){
            $model->updateRules = self::$rules;
            return $model->isValid('update');
        });
    }


    /**
    * Obtiene las Transferencias asociadas con el Estado
    * @return Illuminate\Database\Eloquent\Collection
    */
    public function transferencias()
    {
        return $this->hasMany('App\Transferencia', 'estado_transferencia_id');
    }
}
