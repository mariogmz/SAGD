<?php

namespace App;

class Subfamilia extends LGGModel
{
    //
    protected $table = "subfamilias";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => 'required|max:4|unique:subfamilias',
        'nombre' => 'required|max:45',
        'familia_id' => 'required',
        'margen_id' => 'required'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        Subfamilia::creating(function($subfamilia){
            $subfamilia->clave = strtoupper($subfamilia->clave);
            if ( !$subfamilia->isValid() ){
                return false;
            }
            return true;
        });
        Subfamilia::updating(function($subfamilia){
            $subfamilia->updateRules = self::$rules;
            $subfamilia->updateRules['clave'] .= ',clave,'.$subfamilia->id;
            return $subfamilia->isValid('update');
        });
    }

    /**
     * Get the Familia associated with Subfamilia
     * @return App\Familia
     */
    public function familia()
    {
        return $this->belongsTo('App\Familia');
    }

    /**
     * Get the Margen associated with Subfamilia
     * @return App\Margen
     */
    public function margen()
    {
        return $this->belongsTo('App\Margen');
    }

    /**
     * Get the Productos associated with Subfamilia
     * @return array
     */
    public function productos()
    {
        return $this->hasMany('App\Producto');
    }
}
