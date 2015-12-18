<?php

namespace App;


/**
 * App\Tabulador
 *
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class Tabulador extends LGGModel {

    protected $table = "tabuladores";
    public $timestamps = true;
    protected $fillable = ['valor', 'valor_original', 'especial', 'cliente_id', 'sucursal_id'];

    public static $rules = [
        'valor'          => 'integer|between:1,10',
        'valor_original' => 'integer|between:1,10',
        'especial'       => 'boolean',
        'cliente_id'     => 'required|integer|unique_with:tabuladores,sucursal_id',
        'sucursal_id'    => 'required|integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        Tabulador::creating(function (Tabulador $tabulador) {
            $tabulador->valor_original = $tabulador->valor_original ?: 1;
            $tabulador->valor = $tabulador->valor_original;

            return $tabulador->isValid();
        });
        Tabulador::updating(function (Tabulador $tabulador) {
            $tabulador->updateRules = self::$rules;
            $tabulador->updateRules['cliente_id'] = 'required|integer|unique_with:tabuladores,sucursal_id,' . $tabulador->id;

            return $tabulador->isValid('update');
        });
    }
}
