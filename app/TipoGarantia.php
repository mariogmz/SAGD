<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class TipoGarantia extends Model
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

    /**
     * Define the model hooks
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
    }

    /**
     * This method is responsible for validating the model
     *
     * @return bool
     */
    public function isValid()
    {
        $validation = Validator::make($this->attributes, static ::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();
        return false;
    }
}
