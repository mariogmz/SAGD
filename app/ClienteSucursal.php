<?php

namespace App;


/**
 * App\ClienteSucursal
 *
 * @property integer $id
 * @property integer $tabulador
 * @property integer $tabulador_original
 * @property boolean $habilitada
 * @property boolean $venta_especial
 * @property integer $sucursal_id
 * @property integer $cliente_id
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteSucursal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class ClienteSucursal extends LGGModel {

    //
    protected $table = "clientes_sucursales";
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
        ClienteReferencia::creating(function ($cr) {
            if (!$cr->isValid()) {
                return false;
            }

            return true;
        });
        ClienteSucursal::updating(function ($cr) {
            $cr->updateRules = self::$rules;

            return $cr->isValid('update');
        });
    }


    /**
     * Obtiene los Clientes asociados con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function clientes() {
        return $this->hasMany('App\Cliente', 'cliente_id');
    }
}
