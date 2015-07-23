<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Margen extends Model
{
    //
    protected $table = "margenes";
    public $timestamps = false;
    protected $fillable = ['nombre', 'valor', 'valor_webservice_p1', 'valor_webservice_p8'];

    public static $rules = [
        'nombre' => 'required|max:45',
        'valor' => 'numeric|min:0.0|max:1.0',
        'valor_webservice_p1' => 'numeric|min:0.0|max:1.0',
        'valor_webservice_p8' => 'numeric|min:0.0|max:1.0'
    ];

    /**
     * Define the model hooks
     */
    public static function boot() {
        Margen::creating(function($margen){
            $margen->valor || $margen->valor = 0.0;
            $margen['valor_webservice_p1'] || $margen['valor_webservice_p1'] = 0.0;
            $margen['valor_webservice_p8'] || $margen['valor_webservice_p8'] = 0.0;
            if ( !$margen->isValid() ){
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
