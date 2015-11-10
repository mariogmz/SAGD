<?php

namespace App;


/**
 * App\Guia
 *
 * @property integer $id
 * @property string $nombre
 * @property float $volumen_maximo
 * @property float $ampara_hasta
 * @property integer $paqueteria_id
 * @property integer $estatus_activo_id
 * @property-read \App\Paqueteria $paqueteria
 * @property-read \App\EstatusActivo $estatus
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\GuiaZona[] $guiasZonas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Zona[] $zonas
 * @method static \Illuminate\Database\Query\Builder|\App\Guia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guia whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guia whereVolumenMaximo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guia whereAmparaHasta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guia wherePaqueteriaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guia whereEstatusActivoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Guia whereDeletedAt($value)
 */
class Guia extends LGGModel {

    //
    protected $table = "guias";
    public $timestamps = false;
    protected $fillable = ['nombre', 'volumen_maximo', 'ampara_hasta', 'paqueteria_id', 'estatus_activo_id'];

    public static $rules = [
        'nombre'            => 'max:80',
        'volumen_maximo'    => 'required|numeric|min:0.0',
        'ampara_hasta'      => 'required|numeric|min:0.0',
        'paqueteria_id'     => 'required|integer',
        'estatus_activo_id' => 'required|integer',
    ];
    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Guia::creating(function ($model) {
            return $model->isValid();
        });
        Guia::updating(function ($model) {
            $model->updateRules = self::$rules;

            return $model->isValid('update');
        });
    }


    /**
     * Obtiene la Paqueteria asociada con la Guia
     * @return App\Paqueteria
     */
    public function paqueteria() {
        return $this->belongsTo('App\Paqueteria', 'paqueteria_id');
    }


    /**
     * Obtiene el Estaus Activo asociado con la Guia
     * @return App\EstatusActivo
     */
    public function estatus() {
        return $this->belongsTo('App\EstatusActivo', 'estatus_activo_id');
    }


    /**
     * Obtiene las Guias Zonas asociadas con la Guia
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function guiasZonas() {
        return $this->hasMany('App\GuiaZona', 'guia_id');
    }


    /**
     * Obtiene las Zonas a traves de Guias Zonas asociadas con la Guia
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function zonas() {
        return $this->belongsToMany('App\Zona', 'guias_zonas', 'guia_id', 'zona_id');
    }
}
