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
        'tabulador'          => 'required|max:50',
        'tabulador_original' => 'required|max:50',
        'habilitada'         => 'boolean',
        'venta_especial'     => 'boolean',
        'cliente_id'         => 'required|integer',
        'sucursal_id'        => 'required|integer',
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
     * Obtiene los Clientes asociado con la Sucursal
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function clientes() {
        return $this->hasMany('App\Cliente', 'cliente_id');
    }
}
