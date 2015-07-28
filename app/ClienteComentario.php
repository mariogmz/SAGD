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
}
