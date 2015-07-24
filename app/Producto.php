<?php

namespace App;

class Producto extends LGGModel
{
    //
    protected $table = "productos";
    public $timestamps = true;
    protected $fillable = ['activo', 'clave', 'descripcion', 'descripcion_corta',
        'fecha_entrada', 'numero_parte', 'remate', 'spiff', 'subclave', 'upc'];

    public static $rules = [
        'activo' => 'required|boolean',
        'clave' => 'required|unique:productos|max:60',
        'descripcion' => 'required|max:300',
        'descripcion_corta' => 'max:50',
        'fecha_entrada' => 'required|date',
        'numero_parte' => 'required|unique:productos',
        'remate' => 'required|boolean',
        'spiff' => 'required|numeric',
        'subclave' => 'required',
        'upc' => 'required|unique:productos|integer'
    ];

    /**
     * Define the model hooks
     */
    public static function boot(){
        Producto::creating(function($producto){
            $producto->subclave || $producto->subclave = $producto->numero_parte;
            if ( !$producto->isValid() ){
                return false;
            }
            return true;
        });
    }

}
