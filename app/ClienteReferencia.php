<?php

namespace App;


/**
 * App\ClienteReferencia
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Cliente[] $clientes
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteReferencia whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteReferencia whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 */
class ClienteReferencia extends LGGModel {

    //
    protected $table = "clientes_referencias";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:50'
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
        ClienteReferencia::updating(function ($cr) {
            $cr->updateRules = self::$rules;

            return $cr->isValid('update');
        });
    }


    /**
     * Obtiene los Clientes asociado con la Referencia
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function clientes() {
        return $this->hasMany('App\Cliente', 'cliente_referencia_id');
    }
}
