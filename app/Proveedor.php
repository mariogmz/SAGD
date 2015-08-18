<?php

namespace App;


/**
 * App\Proveedor
 *
 * @property integer $id
 * @property string $clave
 * @property string $razon_social
 * @property boolean $externo
 * @property string $pagina_web
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sucursal[] $sucursales
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Producto[] $productos
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entrada[] $entradas
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reposicion[] $reposiciones
 * @method static \Illuminate\Database\Query\Builder|\App\Proveedor whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proveedor whereClave($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proveedor whereRazonSocial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proveedor whereExterno($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Proveedor wherePaginaWeb($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Proveedor extends LGGModel {

    protected $table = 'proveedores';
    public $timestamps = false;

    protected $fillable = ['clave', 'razon_social', 'externo', 'pagina_web'];
    public static $rules = [
        'clave'        => 'required|max:6|alpha|unique:proveedores',
        'razon_social' => 'required',
        'externo'      => 'required|boolean',
        'pagina_web'   => 'url'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        Proveedor::creating(function ($proveedor) {
            $proveedor->clave = strtoupper($proveedor->clave);
            if (!$proveedor->isValid()) {
                return false;
            }

            return true;
        });
        Proveedor::updating(function ($proveedor) {
            $proveedor->updateRules = self::$rules;
            $proveedor->updateRules['clave'] .= ',clave,' . $proveedor->id;

            return $proveedor->isValid('update');
        });
    }

    /**
     * Obtiene las sucursales asociadas al proveedor
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function sucursales() {
        return $this->hasMany('App\Sucursal');
    }

    /**
     * Obtiene los productos asociados con el proveedor
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function productos() {
        return $this->belongsToMany('App\Producto', 'productos_sucursales',
            'proveedor_id', 'producto_id');
    }


    /**
     * Obtiene las Entradas asociadas con el Proveedor
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function entradas() {
        return $this->hasMany('App\Entrada', 'proveedor_id');
    }

    /**
     * Obtiene las reposiciones obtenidas del proveedor
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function reposiciones() {
        return $this->hasMany('App\Reposicion');
    }

}
