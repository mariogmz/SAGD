<?php

namespace App;


class Configuracion extends LGGModel {

    protected $table = 'configuraciones';
    public $timestamps = false;

    protected $fillable = ['nombre', 'tipo', 'modulo'];
    public static $rules = [
        'nombre' => 'required|string|max:15|alpha_dash',
        'tipo'   => 'required|string|max:10',
        'modulo' => 'required|string|max:10'
    ];

    /**
     * Define the model hooks
     */
    public static function boot()
    {
        Configuracion::creating(function ($config)
        {
            $config->nombre = strtoupper($config->nombre);
            $config->tipo = strtoupper($config->tipo);
            $config->modulo = strtoupper($config->modulo);
            if (!$config->isValid())
            {
                return false;
            }

            return true;
        });
    }


}
