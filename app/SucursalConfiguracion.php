<?php

namespace App;


class SucursalConfiguracion extends LGGModel {

    protected $table = 'sucursales_configuraciones';
    public $timestamps = false;

    protected $fillable = ['valor_numero', 'valor_texto', 'sucursal_id', 'configuracion_id'];
    public static $rules = [
        'valor_numero' => 'numeric|required_without:valor_texto',
        'valor_texto'  => 'string|required_without:valor_numero'
    ];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot()
    {
        SucursalConfiguracion::creating(function ($sucursal_configuracion)
        {
            if (!$sucursal_configuracion->isValid() || !(empty($sucursal_configuracion->valor_numero) xor empty($sucursal_configuracion->valor_texto)))
            {
                return false;
            }

            return true;
        });
    }

    /**
     * Obtiene la sucursal asociada al valor de la configuracion
     * @returns App\Sucursal
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene la sucursal asociada al valor de la configuracion
     * @returns App\Configuracion
     */
    public function configuracion()
    {
        return $this->belongsTo('App\Configuracion');
    }
}
