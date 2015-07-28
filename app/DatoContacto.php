<?php

namespace App;


class DatoContacto extends LGGModel {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'datos_contactos';

    public $timestamps = false;
    protected $fillable = ['direccion', 'telefono', 'email', 'skype', 'fotografia_url', 'empleado_id'];
    public static $rules = [
        'direccion'      => 'string|max:100',
        'telefono'       => 'string|max:20',
        'email'          => 'email|unique:datos_contactos',
        'skype'          => 'string',
        'fotografia_url' => 'url',
        'empleado_id'    => 'required|integer'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        DatoContacto::creating(function ($dato_contacto)
        {
//            $dato_contacto->email = strtoupper($dato_contacto->email);
            if (!$dato_contacto->isValid())
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene el empleado asociado al dato de contacto
     * @return App\Empleado
     */
    public function empleado()
    {
        return $this->belongsTo('App\Empleado');
    }

}
