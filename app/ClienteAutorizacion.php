<?php

namespace App;


/**
 * App\ClienteAutorizacion
 *
 * @property integer $id
 * @property integer $clientes_autorizado_id
 * @property string $nombre_autorizado
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $cliente_id
 * @property integer $cliente_autorizado_id
 * @property-read \App\Cliente $cliente
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereClientesAutorizadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereNombreAutorizado($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereClienteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereClienteAutorizadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteAutorizacion whereDeletedAt($value)
 */
class ClienteAutorizacion extends LGGModel {

    protected $table = "clientes_autorizaciones";
    public $timestamps = true;
    protected $fillable = ['cliente_id', 'nombre_autorizado', 'cliente_autorizado_id'];

    public static $rules = [
        'cliente_id'            => 'required|integer',
        'nombre_autorizado'     => 'string|max:200',
        'cliente_autorizado_id' => 'integer'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        ClienteAutorizacion::creating(function ($ca) {
            if (!$ca->isValid()) {
                return false;
            }

            return true;
        });
        ClienteAutorizacion::updating(function ($ca) {
            $ca->updateRules = self::$rules;

            return $ca->isValid('update');
        });
    }

    public function isValid($method = null) {
        return (is_null($this['cliente_autorizado_id']) xor is_null($this['nombre_autorizado'])) &&
        parent::isValid($method);
    }


    /**
     * Obtiene el Cliente asociado con la Autorizacion
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function cliente() {
        return $this->belongsTo('App\Cliente', 'cliente_id');
    }
}
