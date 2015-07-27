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
     * @codeCoverageIgnore
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

    /**
     * Gets the Tipo Garantia associated with Producto
     * @return App\TipoGarantia
     */
    public function tipoGarantia()
    {
        return $this->belongsTo('App\TipoGarantia', 'tipo_garantia_id');
    }

    /**
     * Gets the Marca associated with Producto
     * @return App\Marca
     */
    public function marca()
    {
        return $this->belongsTo('App\Marca', 'marca_id');
    }

    /**
     * Gets the Marge associated with Producto
     * @return App\Margen
     */
    public function margen()
    {
        return $this->belongsTo('App\Margen', 'margen_id');
    }

    /**
     * Get the Unidad associated with Producto
     * @return App\Unidad
     */
    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    /**
     * Get the Subfamilia associated with Producto
     * @return App\Subfamilia
     */
    public function subfamilia()
    {
        return $this->belongsTo('App\Subfamilia');
    }

    /**
     * Obtiene la Dimension de Producto
     * @return App\Dimension
     */
    public function dimension()
    {
        return $this->hasOne('App\Dimension');
    }
}
