<?php

namespace App;

class ClienteReferencia extends LGGModel
{
    //
    protected $table = "clientes_referencias";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:50'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ClienteReferencia::creating(function($cr){
            if ( !$cr->isValid() ){
                return false;
            }
            return true;
        });
    }


    /**
    * Obtiene los Clientes asociado con la Referencia
    * @return Illuminate\Database\Eloquent\Collection::class
    */
    public function clientes()
    {
        return $this->hasMany('App\Cliente', 'cliente_referencia_id');
    }
}
