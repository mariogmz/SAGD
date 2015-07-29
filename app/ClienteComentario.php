<?php

namespace App;

class ClienteComentario extends LGGModel
{
    //
    protected $table = "clientes_comentarios";
    public $timestamps = false;
    protected $fillable = ['comentario'];

    public static $rules = [
        'comentario' => 'required|max:200',
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        ClienteComentario::creating(function($cc){
            if ( !$cc->isValid() ){
                return false;
            }
            return true;
        });
    }


    /**
    * Obtiene el Cliente asociado con el Comentario
    * @return App\Cliente
    */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }


    /**
    * Obtiene el Empleado asociado con el Comentario
    * @return App\Empleado
    */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado', 'empleado_id');
    }
}
