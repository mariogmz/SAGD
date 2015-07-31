<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TipoGarantia extends LGGModel
{
    //
    protected $table = "tipos_garantias";
    public $timestamps = false;
    protected $fillable = ['seriado', 'descripcion', 'dias'];

    public static $rules = [
        'seriado' => 'boolean',
        'descripcion' => 'required|max:45',
        'dias' => 'integer|min:0'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot(){
        TipoGarantia::creating(function($tipogarantia){
            $tipogarantia->seriado = (empty($tipogarantia->seriado) ? true : $tipogarantia->seriado);
            $tipogarantia->dias = (empty($tipogarantia->dias) ? 0 : $tipogarantia->seriado);
            if ( ! $tipogarantia->isValid() ){
                return false;
            }
            return true;
        });
        TipoGarantia::updating(function($tipogarantia){
            $tipogarantia->updateRules = self::$rules;
            $tipogarantia->seriado = (empty($tipogarantia->seriado) ? true : $tipogarantia->seriado);
            $tipogarantia->dias = (empty($tipogarantia->dias) ? 0 : $tipogarantia->seriado);
            return $tipogarantia->isValid('update');
        });
    }

    public function productos()
    {
        return $this->hasMany('App\Producto', 'tipo_garantia_id');
    }
}
