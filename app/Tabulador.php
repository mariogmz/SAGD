<?php

namespace App;


/**
 * App\Tabulador
 *
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property integer $id
 * @property integer $valor
 * @property integer $valor_original
 * @property boolean $especial
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $cliente_id
 * @property integer $sucursal_id
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Cliente $cliente
 * @property-read \App\Sucursal $sucursal
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereValor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereValorOriginal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereEspecial($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereSucursalId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Tabulador whereDeletedAt($value)
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

    /**
     * Este override de isValid es para agregar validación adicional
     * @codeCoverageIgnore
     * @param null $method
     * @return bool
     */
    public function isValid($method = null) {
        return parent::isValid($method)
        && !empty($sucursal = Sucursal::find($this->sucursal_id))
        && !$sucursal->proveedor->externo;
    }

    /**
     * Obtiene el cliente asociado a este tabulador
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Obtiene la sucursal asociada a este tabulador
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sucursal() {
        return $this->belongsTo('App\Sucursal');
    }

}
