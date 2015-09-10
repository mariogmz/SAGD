<?php

namespace App;


/**
 * App\Subfamilia
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property integer $familia_id
 * @property integer $margen_id
 * @property-read \App\Familia $familia
 * @property-read \App\Margen $margen
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Producto[] $productos
 * @method static \Illuminate\Database\Query\Builder|\App\Subfamilia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subfamilia whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subfamilia whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subfamilia whereFamiliaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subfamilia whereMargenId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Subfamilia extends LGGModel {

    //
    protected $table = "subfamilias";
    public $timestamps = false;
    protected $fillable = ['clave', 'nombre', 'familia_id', 'margen_id'];

    public static $rules = [
        'clave'      => 'required|max:4|unique:subfamilias',
        'nombre'     => 'required|max:45',
        'familia_id' => 'required|integer',
        'margen_id'  => 'integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Subfamilia::creating(function ($subfamilia) {
            $subfamilia->clave = strtoupper($subfamilia->clave);
            if (!$subfamilia->isValid()) {
                return false;
            }

            return true;
        });
        Subfamilia::updating(function ($subfamilia) {
            $subfamilia->updateRules = self::$rules;
            $subfamilia->updateRules['clave'] .= ',clave,' . $subfamilia->id;

            return $subfamilia->isValid('update');
        });
    }

    /**
     * Get the Familia associated with Subfamilia
     * @return App\Familia
     */
    public function familia() {
        return $this->belongsTo('App\Familia');
    }

    /**
     * Get the Margen associated with Subfamilia
     * @return App\Margen
     */
    public function margen() {
        return $this->belongsTo('App\Margen');
    }

    /**
     * Get the Productos associated with Subfamilia
     * @return array
     */
    public function productos() {
        return $this->hasMany('App\Producto');
    }
}
