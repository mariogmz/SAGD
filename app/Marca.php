<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Marca extends LGGModel
{
    protected $table = 'marcas';

    public $timestamps = false;

    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave' => ['required','max:3','alpha','regex:/[A-Z]{3}/', 'unique:marcas'],
        'nombre' => 'required|max:25'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Marca::creating(function($marca){
            $marca->clave = strtoupper($marca->clave);
            if ( !$marca->isValid() ){
                return false;
            }
            return true;
        });
        Marca::updating(function($marca){
            $marca->updateRules = self::$rules;
            $marca->updateRules['clave'] = [
                'required', 'max:3', 'alpha', 'regex:/[A-Z]{3}/',
                'unique:marcas,clave,'.$marca->id];
            return $marca->isValid('update');
        });
    }

    /**
     * Return the products associated with Marca
     *
     * @return array
     */
    public function productos()
    {
        return $this->hasMany('App\Producto', 'marca_id');
    }
}
