<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class DatoContacto extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datos_contacto';
    protected $primaryKey = 'empleado_id';

    public $timestamps = false;
    protected $fillable = ['direccion', 'telefono', 'email', 'skype', 'fotografia_url'];
    public static $rules = [
        'telefono'       => 'numeric|max:11',
        'email'          => 'email|unique:datos_contactos',
        'fotografia_url' => 'active_url'
    ];

    public function isValid()
    {
        $validation = Validator::make($this->attributes, static::$rules);
        if ($validation->passes()) return true;
        $this->errors = $validation->messages();

        return false;
    }
}
