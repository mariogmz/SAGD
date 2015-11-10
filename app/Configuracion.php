<?php

namespace App;


/**
 * App\Configuracion
 *
 * @property integer $id
 * @property string $nombre
 * @property string $tipo
 * @property string $modulo
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SucursalConfiguracion[] $sucursalesConfiguraciones
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereTipo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereModulo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Configuracion whereDeletedAt($value)
 */
class Configuracion extends LGGModel {

    protected $table = 'configuraciones';
    public $timestamps = false;

    protected $fillable = ['nombre', 'tipo', 'modulo'];
    public static $rules = [
        'nombre' => 'required|string|max:15|alpha_dash',
        'tipo'   => 'required|string|max:10',
        'modulo' => 'required|string|max:10'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Configuracion::creating(function ($config) {
            $config->nombre = strtoupper($config->nombre);
            $config->tipo = strtoupper($config->tipo);
            $config->modulo = strtoupper($config->modulo);
            if (!$config->isValid()) {
                return false;
            }

            return true;
        });
        Configuracion::updating(function ($config) {
            $config->updateRules = self::$rules;

            return $config->isValid('update');
        });
    }

    /**
     * Obtiene los valores de la configuración para todas las sucursales
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function sucursalesConfiguraciones() {
        return $this->hasMany('App\SucursalConfiguracion');
    }

}
