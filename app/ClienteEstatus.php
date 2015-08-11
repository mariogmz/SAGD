<?php

namespace App;

class ClienteEstatus extends LGGModel
{
    //
    protected $table = "clientes_estatus";
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
        ClienteEstatus::creating(function($clienteEstatus){
            if ( !$clienteEstatus->isValid() ){
                return false;
            }
            return true;
        });
        ClienteEstatus::updating(function($ce){
            $ce->updateRules = self::$rules;
            return $ce->isValid('update');
        });
    }


    /**
    * Obtiene los Clientes asociado con el Estatus
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function clientes()
    {
        return $this->hasMany('App\Cliente', 'cliente_estatus_id');
    }
}
