<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Domicilio extends Model {

    protected $table = 'domicilios';
    public $timestamps = false;

    protected $fillable = ['calle', 'localidad', 'codigo_postal_id', 'telefono_id'];
    public static $rules = [
        'calle'            => 'required|string|max:45',
        'localidad'        => 'required|string|max:45',
        'codigo_postal_id' => 'required|integer',
        'telefono_id'      => 'required|integer'
    ];

    /**
     * Define the model hooks
     */
    public static function boot()
    {
        DatoContacto::creating(function ($domicilio)
        {
            if (!$domicilio->isValid())
            {
                return false;
            }

            return true;
        });
    }

    public function isValid()
    {
        $validation = Validator::make($this->attributes, static::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();

        return false;
    }
}
