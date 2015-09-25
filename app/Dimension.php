<?php

namespace App;


/**
 * App\Dimension
 *
 * @property integer $id
 * @property float $largo
 * @property float $ancho
 * @property float $alto
 * @property float $peso
 * @property integer $producto_id
 * @property-read \App\Producto $producto
 * @method static \Illuminate\Database\Query\Builder|\App\Dimension whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dimension whereLargo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dimension whereAncho($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dimension whereAlto($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dimension wherePeso($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dimension whereProductoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Dimension extends LGGModel {

    //
    protected $table = "dimensiones";
    public $timestamps = false;
    protected $fillable = ['largo', 'ancho', 'alto', 'peso', 'producto_id'];

    public static $rules = [
        'largo'       => 'required|numeric|min:0.0',
        'ancho'       => 'required|numeric|min:0.0',
        'alto'        => 'required|numeric|min:0.0',
        'peso'        => 'required|numeric|min:0.0',
        'producto_id' => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Dimension::creating(function ($dimension) {
            if (!$dimension->isValid()) {
                return false;
            }

            return true;
        });
        Dimension::updating(function ($dimension) {
            $dimension->updateRules = self::$rules;

            return $dimension->isValid('update');
        });
    }

    /**
     * Gets the Producto associated with the Dimension
     * @return App\Producto
     */
    public function producto() {
        return $this->belongsTo('App\Producto');
    }
}
