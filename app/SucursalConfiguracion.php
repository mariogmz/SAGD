<?php

namespace App;


/**
 * App\SucursalConfiguracion
 *
 * @property integer $id
 * @property float $valor_numero
 * @property string $valor_texto
 * @property integer $sucursal_id
 * @property integer $configuracion_id
 * @property-read \App\Sucursal $sucursal
 * @property-read \App\Configuracion $configuracion
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalConfiguracion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalConfiguracion whereValorNumero($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalConfiguracion whereValorTexto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalConfiguracion whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SucursalConfiguracion whereConfiguracionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class SucursalConfiguracion extends LGGModel {

    protected $table = 'sucursales_configuraciones';
    public $timestamps = false;

    protected $fillable = ['valor_numero', 'valor_texto', 'sucursal_id', 'configuracion_id'];
    public static $rules = [
        'valor_numero' => 'numeric|required_without:valor_texto',
        'valor_texto'  => 'string|required_without:valor_numero'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        SucursalConfiguracion::creating(function ($sucursal_configuracion) {
            if (!$sucursal_configuracion->isValid() || !(empty($sucursal_configuracion->valor_numero) xor empty($sucursal_configuracion->valor_texto))) {
                return false;
            }

            return true;
        });
        SucursalConfiguracion::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid();
        });
    }

    /**
     * Obtiene la sucursal asociada al valor de la configuracion
     * @returns App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene la sucursal asociada al valor de la configuracion
     * @returns App\Configuracion
     */
    public function configuracion() {
        return $this->belongsTo('App\Configuracion');
    }
}
