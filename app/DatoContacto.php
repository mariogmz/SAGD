<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;


class DatoContacto extends LGGModel {

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

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        DatoContacto::creating(function ($dato_contacto)
        {
            $dato_contacto->email = strtoupper($dato_contacto->email);
            if (!$dato_contacto->isValid())
            {
                return false;
            }

            return true;
        });
    }
}
