<?php

namespace App;

class ClienteAutorizacion extends LGGModel
{
    //
    protected $table = "clientes_autorizaciones";
    public $timestamps = false;
    protected $fillable = ['nombre_autorizado', 'cliente_id', 'cliente_autorizado_id'];

    public static $rules = [
        'cliente_autorizado_id' => '',
        'nombre_autorizado' => 'max:200',
        'cliente_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ClienteAutorizacion::creating(function($ca){
            if ( !$ca->isValid() ){
                return false;
            }
            return true;
        });
        ClienteAutorizacion::updating(function($ca){
            $ca->updateRules = self::$rules;
            return $ca->isValid('update');
        });
    }

    public function isValid($method=null)
    {
        return ( is_null($this['cliente_autorizado_id']) xor is_null($this['nombre_autorizado']) ) &&
            parent::isValid($method);
    }


    /**
    * Obtiene el Cliente asociado con la Autorizacion
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }
}
