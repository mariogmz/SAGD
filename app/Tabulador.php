<?php

namespace App;


/**
 * App\Tabulador
 *
 * @property integer $id
 * @property integer $tabulador
 * @property integer $tabulador_original
 * @property boolean $habilitada
 * @property boolean $venta_especial
 * @property integer $sucursal_id
 * @property integer $cliente_id
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Tabulador extends LGGModel {

    //
    protected $table = "tabuladores";
    public $timestamps = false;
    protected $fillable = ['tabulador', 'tabulador_original', 'habilitada', 'venta_especial', 'cliente_id', 'sucursal_id'];

    public static $rules = [
        'tabulador'          => 'integer|required|min:1',
        'tabulador_original' => 'integer|required|min:1',
        'habilitada'         => 'boolean|required',
        'venta_especial'     => 'boolean|required',
        'cliente_id'         => 'integer|required',
        'sucursal_id'        => 'integer|required',
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Tabulador::creating(function ($cr) {
            if (!$cr->isValid()) {
                return false;
            }

            return true;
        });
        Tabulador::updating(function ($cr) {
            $cr->updateRules = self::$rules;

            return $cr->isValid('update');
        });
    }


    /**
     * Obtiene los Clientes asociados con el registro de Tabulador por Sucursal
     * @return App\Cliente
     */
    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Obtiene las Sucursales asociadas con el registro de Tabulador
     * @return App\Sucursal
     */
    public function sucursal() {
        return $this->belongsTo(Sucursal::class);
    }
}
