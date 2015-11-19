<?php

namespace App;


/**
 * App\TipoGarantia
 *
 * @property integer $id
 * @property boolean $seriado
 * @property string $descripcion
 * @property integer $dias
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Producto[] $productos
 * @method static \Illuminate\Database\Query\Builder|\App\TipoGarantia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoGarantia whereSeriado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoGarantia whereDescripcion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\TipoGarantia whereDias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\TipoGarantia whereDeletedAt($value)
 */
class TipoGarantia extends LGGModel {

    //
    protected $table = "tipos_garantias";
    public $timestamps = false;
    protected $fillable = ['seriado', 'descripcion', 'dias'];

    public static $rules = [
        'seriado'     => 'boolean',
        'descripcion' => 'required|max:45',
        'dias'        => 'integer|min:0'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        TipoGarantia::creating(function ($tipogarantia) {
            $tipogarantia->seriado = (is_null($tipogarantia->seriado) ? true : $tipogarantia->seriado);
            $tipogarantia->dias = (empty($tipogarantia->dias) ? 0 : $tipogarantia->dias);
            if (!$tipogarantia->isValid()) {
                return false;
            }

            return true;
        });
        TipoGarantia::updating(function ($tipogarantia) {
            $tipogarantia->updateRules = self::$rules;
            $tipogarantia->seriado = (is_null($tipogarantia->seriado) ? true : $tipogarantia->seriado);
            $tipogarantia->dias = (empty($tipogarantia->dias) ? 0 : $tipogarantia->dias);

            return $tipogarantia->isValid('update');
        });
    }

    public function productos() {
        return $this->hasMany('App\Producto', 'tipo_garantia_id');
    }
}
