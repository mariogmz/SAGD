<?php

namespace App;


/**
 * App\Margen
 *
 * @property integer $id
 * @property string $nombre
 * @property float $valor
 * @property float $valor_webservice_p1
 * @property float $valor_webservice_p8
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subfamilia[] $subfamilias
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Producto[] $productos
 * @method static \Illuminate\Database\Query\Builder|\App\Margen whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Margen whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Margen whereValor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Margen whereValorWebserviceP1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Margen whereValorWebserviceP8($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Margen whereDeletedAt($value)
 */
class Margen extends LGGModel {

    //
    protected $table = "margenes";
    public $timestamps = false;
    protected $fillable = ['nombre', 'valor', 'valor_webservice_p1', 'valor_webservice_p8'];

    public static $rules = [
        'nombre'              => 'required|max:45',
        'valor'               => 'required|numeric|min:0.0|max:1.0',
        'valor_webservice_p1' => 'required|numeric|min:0.0|max:1.0',
        'valor_webservice_p8' => 'required|numeric|min:0.0|max:1.0'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Margen::creating(function ($margen) {
            $margen->valor || $margen->valor = 0.0;
            $margen['valor_webservice_p1'] || $margen['valor_webservice_p1'] = 0.0;
            $margen['valor_webservice_p8'] || $margen['valor_webservice_p8'] = 0.0;
            if (!$margen->isValid()) {
                return false;
            }

            return true;
        });
        Margen::updating(function ($margen) {
            $margen->updateRules = self::$rules;
            $margen->valor || $margen->valor = 0.0;
            $margen['valor_webservice_p1'] || $margen['valor_webservice_p1'] = 0.0;
            $margen['valor_webservice_p8'] || $margen['valor_webservice_p8'] = 0.0;

            return $margen->isValid('update');
        });
    }

    /**
     * Get the associated subfamilias with margen
     * @return array
     */
    public function subfamilias() {
        return $this->hasMany('App\Subfamilia');
    }

    /**
     * Get the associated productos with margen
     * @return array
     */
    public function productos() {
        return $this->hasMany('App\Producto');
    }
}
