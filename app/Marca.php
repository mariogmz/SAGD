<?php

namespace App;


/**
 * App\Marca
 *
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property integer $icecat_supplier_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Producto[] $productos
 * @method static \Illuminate\Database\Query\Builder|\App\Marca whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Marca whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Marca whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Marca whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IcecatSupplier[] $icecatSuppliers
 */
class Marca extends LGGModel {

    protected $table = 'marcas';

    public $timestamps = false;

    protected $fillable = ['clave', 'nombre'];

    public static $rules = [
        'clave'              => ['required', 'max:3', 'alpha_num', 'unique:marcas'],
        'nombre'             => 'required|max:25'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Marca::creating(function ($marca) {
            $marca->clave = strtoupper($marca->clave);
            if (!$marca->isValid()) {
                return false;
            }

            return true;
        });
        Marca::updating(function ($marca) {
            $marca->updateRules = self::$rules;
            $marca->updateRules['clave'] = [
                'required', 'max:3', 'alpha', 'regex:/[A-Z]{1,3}/',
                'unique:marcas,clave,' . $marca->id];

            return $marca->isValid('update');
        });
    }

    /**
     * Obtiene los productos asociados con la Marca
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function productos() {
        return $this->hasMany('App\Producto', 'marca_id');
    }

    /**
     * Obtiene los suppliers de icecat asociados con la Marca
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function icecatSuppliers() {
        return $this->hasMany('App\IcecatSupplier', 'marca_id');
    }
}
