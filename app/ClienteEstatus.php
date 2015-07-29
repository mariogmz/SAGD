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
