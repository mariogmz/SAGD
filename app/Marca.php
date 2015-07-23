<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Marca extends Model
{
    //

    public $timestamps = false;

    protected $fillable = ['clave', 'nombre'];
    public static $rules = [
        'clave' => 'required',
        'nombre' => 'required'
    ];

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
