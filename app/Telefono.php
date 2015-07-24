<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Telefono extends Model {

    protected $table = 'telefonos';
    public $timestamps = false;

    protected $fillable = ['numero', 'tipo'];
    public static $rules = [
        'numero' => 'required|size:11|unique:telefonos',
        'tipo'   => 'required|size:45'
    ];

    /**
     * Define the model hooks
     */
    public static function boot()
    {
        Telefono::creating(function ($telefono)
        {
            if (!$telefono->isValid())
            {
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
        $validation = Validator::make($this->attributes, static::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();

        return false;
    }
}
