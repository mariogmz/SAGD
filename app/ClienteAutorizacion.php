<?php

namespace App;

class ClienteAutorizacion extends LGGModel
{
    //
    protected $table = "clientes_autorizaciones";
    public $timestamps = false;
    protected $fillable = ['nombre_autorizado'];

    public static $rules = [
        'cliente_autorizado_id' => '',
        'nombre_autorizado' => 'max:200'
    ];

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
    }

    public function isValid($method=null)
    {
        return ( empty($this['cliente_autorizado_id']) xor empty($this['nombre_autorizado']) ) &&
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
