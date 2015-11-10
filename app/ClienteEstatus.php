<?php

namespace App;


/**
 * Definicion de estatus:
 * 1 => Nuevo. Cliente se acaba de registrar pero aun no verifica su cuenta via email.
 * 
 * 2 => Activo. Cliente verifico su cuenta y ya puede realizar operaciones.
 * 3 => Inactivo. Cliente dado de baja (logicamente).
 *
 * @property integer $id
 * @property string $nombre
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Cliente[] $clientes
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteEstatus whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteEstatus whereNombre($value)
 * @method static \Illuminate\Database\Query\Builder|\App\LGGModel last()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\ClienteEstatus whereDeletedAt($value)
 */

class ClienteEstatus extends LGGModel {

    //
    protected $table = "clientes_estatus";
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public static $rules = [
        'nombre' => 'required|max:45'
    ];

    public $updateRules = [];

    /**
     * Define the model hooks
     * @codeCoverageIgnore
     */
    public static function boot() {
        parent::boot();
        ClienteEstatus::creating(function ($clienteEstatus) {
            if (!$clienteEstatus->isValid()) {
                return false;
            }

            return true;
        });
        ClienteEstatus::updating(function ($ce) {
            $ce->updateRules = self::$rules;

            return $ce->isValid('update');
        });
    }


    /**
     * Obtiene los Clientes asociado con el Estatus
     * @return Illuminate\Database\Eloquent\Collection::class
     */
    public function clientes() {
        return $this->hasMany('App\Cliente', 'cliente_estatus_id');
    }
}
